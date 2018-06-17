<?php
namespace ProfPlatforma\Users\Controllers;

use App\Mail\RegistrationComplited;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use ProfPlatforma\Users\Models\User;
use App\Http\Controllers\Controller;
use ProfPlatforma\Users\Requests\CreateUserRequest;
use ProfPlatforma\Users\Requests\UpdateUserRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\ImageManagerStatic as Image;

class UserController extends Controller
{
    /**
     * Создать пользователя (Create user)
     * @param CreateUserRequest $request
     * @return array
     *
     * @response {
     *  "id": "1"
     * }
     */
    public function register(CreateUserRequest $request)
    {
        $credentials = $request->validated();

        $credentials['password'] = bcrypt($credentials['password']);
        $user = User::create($credentials);

        if ($user && $request->hasFile('photo')) {
            $image = $request->photo;
            $image_resize = Image::make($image)->resize(212, 212);
            $image_resize->store('public');
//            Storage::put('\public\resize\\'. substr($image, 7), (string) $image_resize->resize(212, 212)->encode() );
            $user->photo = $image_resize;
            $user->save();

        }

        if($user &&  $role = $request->get('role')) {
            $role = DB::select("SELECT id FROM roles WHERE title='$role'");
            DB::table('user_roles')->insert(['user_id' => $user->id, 'role_id' => $role[0]->id]);
        }

        if ($user && $request->get('categories')) {
            $user->createCategories($request->get('categories'));
        }

        Mail::to($user->email)
            ->send(new RegistrationComplited($user, $request->get('password')));
        return [
            'id' => $user->id,
        ];
    }

    /**
     * Авторизация (Authorization)
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $data = $request->only('login', 'password');
        if ((!strstr($data['login'], '@'))) {
            $credentials['phone'] = $data['login'];
        } else {
            $credentials['email'] = $data['login'];
        }
        $credentials['password'] = $data['password'];

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $success['token'] = $user->createToken('MyApp')->accessToken;
            $success['status'] = true;
            $success['role'] = $user->roles;
            $success['user'] = $user;
            $success['user']['modules'] = $user->modules;
            return response()->json($success, Response::HTTP_OK);
        } else {
            return response()->json(['Ошибка' => 'Не авторизованы'], Response::HTTP_UNAUTHORIZED);
        }
    }

    /**
     * Обновить пользователя (Update user)
     *
     * @response
     * @param UpdateUserRequest $request
     * @param User $user
     * @return array|User
     */

    public function update(UpdateUserRequest $request, User $user)
    {
        $values = $request->all();
        if (!empty($values['password'])) {
            $values['password'] = bcrypt($values['password']);
        }
        foreach ($values as $key => $value) {
            if ($key == 'phone' || $key == 'email') {
                $temp = ($key == 'phone') ? $user->phone : $user->email;
                $count = User::where($key, $request->get($key, null))
                    ->where($key, '!=', $temp)
                    ->count();
                if ($count > 0) {
                    return [
                        'error' => $key . ' already in use'
                    ];
                }
            }

        }
        $user->update($values);
        return $user;
    }


    /**
     * Получить профиль пользователя (Get user profile)
     */
    public function getCurrentUser()
    {
      return [
            'user' => Auth::user(),
            'modules' => Auth::user()->modules,
        ];
    }
}