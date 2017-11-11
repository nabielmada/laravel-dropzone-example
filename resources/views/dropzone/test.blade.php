<!DOCTYPE HTML>
<html>
    <head>
        <title>Hello World</title>
        <link rel="stylesheet" href="{{ asset("/dropzone/dropzone.css") }}">
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </head>
    <body>
        <form action="test" method="post"  enctype="multipart/form-data">
            <input type="text" name="title"><br>
            {{ csrf_field() }}
            <div id="dz" class="dropzone">
                <div class="dz-message">
                    <div class="drag-icon-cph">
                        <i class="material-icons">touch_app</i>
                    </div>
                    <h3>Drop files here or click to upload.</h3>
                </div>
            </div>

            <input type="submit"><br>
        </form>
        
        <script src="{{ asset("/dropzone/jquery.min.js") }}"></script>
        <script src="{{ asset("/dropzone/dropzone.js") }}"></script>
                <script>
                    $(function(){
                       
                        Dropzone.autoDiscover = false;
                        $("#dz").dropzone({
                            url: "{{ url('/fu') }}",
                            paramName: "image",
                            maxFilesize:1,
                            maxFiles:4,
                            addRemoveLinks: true,
                            headers:{
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success:function(file,response){
                                $(file.previewElement).attr('server-file',response.filename);
                            },
                            error:function(file,response){
                                console.log(response);
                            },
                            removedfile:function(file){
                                $.ajax({
                                    method:"POST",
                                    url:"{{ url('/fr') }}",
                                    headers:{
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    },
                                    data:{
                                        'filename': $(file.previewElement).attr('server-file')
                                    },
                                    success:function( rs ){
                                        $(file.previewElement).remove();
                                        console.log(rs.responseJSON);
                                    },
                                    error:function( rs ){
                                        console.log(rs.responseJSON);
                                    }
                                });
                            },
                            
                            dictDefaultMessage: "فایل های خود را اینجا بندازید",
                            dictFallbackMessage: "مرورگر شماامکان آپلود با درگ دراپ ندارد",
                            dictFileTooBig: "فایل خیلی سنگین است (@{{filesize}}MiB). حداکثر حجم مجاز: @{{maxFilesize}}MiB.",
                            dictInvalidFileType: "این نوع از فایل را نمیتوانید آپلود کنید",
                            dictCancelUpload: "لغو آپلود",
                            dictCancelUploadConfirmation: "آیا برای لغو آپلود مطمئنید؟",
                            dictRemoveFile: "حزف فایل",
                            dictRemoveFileConfirmation: "برای حزف فایل مطمئن هستید؟",
                            dictMaxFilesExceeded: "شما فایل بیشتری نمیتوانید آپلود کنید"
                        });
                    });

                </script>
                    
    </body>
</html>