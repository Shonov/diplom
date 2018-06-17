
const getTemplate = `
<div class="dz-preview dz-file-preview">
    <div class="dz-image" style="width: 200px;height: 300px">
        <img data-dz-thumbnail />
    </div>
    <div class="dz-details">
        <div class="dz-size"><span data-dz-size></span></div>
        <div class="dz-filename"><span data-dz-name></span></div>
    </div>
    <div class="dz-error-message"><span data-dz-errormessage></span></div>
    <div class="dz-success-mark"><i class="fa fa-check"></i></div>
    <div class="dz-error-mark"><i class="fa fa-close"></i></div>
</div>
`;

export default {
    methods: {
        DropZoneAddedFile(file) {
            this.order.photos.push(file);
        },
        removeThisFile (file) {
            let index = this.order.photos.indexOf(file);
            this.order.photos.splice([index], 1);
        },
        DropZoneSending(file, xhr, formData) {
            console.log(file);
        },
        DropZoneError(file) {
            console.log(file);
        },
        DropZoneSuccess(file, response) {
            console.log(file);
        },
        DropZoneProcessQueue() {
            this.$refs.dropzone.processQueue();
        },
        DropZoneComplete(files) {
            console.log(files);
        },
    },
    data: () => ({
        uploading: false,
        dropzoneOptions: {
            enctype: "multipart/form-data",
            method: 'POST',
            paramName: "image",
            uploadMultiple: true,
            acceptedFiles: '.png,.jpg,.jpeg,.gif',
            parallelUploads: 6,
            previewTemplate: getTemplate,
            url: 'http://127.0.0.1:8000/api/orders/upload',
            thumbnailWidth: 200,
            thumbnailHeight: 300,
            addRemoveLinks: true,
            dictDefaultMessage: "<i class='fa fa-cloud-upload'></i>Загрузить фото",
            dictRemoveFile: "Удалить",
            maxFilesize: 3.0,
            autoProcessQueue: false,
            headers: {
                'Authorization': `Bearer ${localStorage.token}`,
            },
        },
        order: {
            title: '',
            description: '',
            coordinates: '',
            address:'',
            start_date: '',
            end_date: '',
            time_period:'В любое время',
            budget_scale_id: 1,
            user_id: null,
            photos: []
        },
    }),
}