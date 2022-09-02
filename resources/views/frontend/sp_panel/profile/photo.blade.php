@extends('frontend.sp_panel.profile.layout.app')

@section('content')
<style type="text/css" media="screen">
    .conten {
    float: left;
    padding: 1.875em;
    width: 80%;}
    .heaading{
            font-family: gt-eesti,"Helvetica Neue",Helvetica,Arial,sans-serif;
            -webkit-font-smoothing: antialiased;
            font-size: 13px;
            line-height: 18px;
            -webkit-backface-visibility: hidden;
            color: #054752;
    }
    .pphoto{
        font-size: 22px;
     /* padding-bottom: 4px; */
        color: #4f595a;
    }
    .text-success{
        margin: 0;
       font-size: 13px;
    font-weight: bold;
    }
    .rule-pic{
        olor: #708C91;
    font-size: 13px;
    line-height: 18px;
    padding-left: 0;
    margin: 0;
    font-weight: bold;
    }
</style>
    <div class="conten" style="background-color: #f8f9fa">

        <h3 class="pphoto">Your profile photo</h3>
        <hr>
        <p class="heaading">Add your photo now! Other members will be reassured to see who they'll be travelling with, and you'll find
            your car share much more easily. Photos also help members to recognise each other</p>
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <div class="alert alert-danger alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    {{$error}}
                </div>
            @endforeach
        @endif
        @if(session()->has('message'))
            <div class="alert alert-success alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                {{ session()->get('message') }}
            </div>
        @endif
        <div class="card" style="border: 1px solid #b5a0a0;">
            <div class="card-body">
                <div class="row">
                    <div class="col-8 text-center">
                        <img src="" class="img-fluid rounded img-thumbnail mx-auto"
                             style="height: 150px;width: 150px;display: none"
                             id="previewLogo"><i id="user" class="fas fa-user" style="font-size: 80px;color: #4491c7;"></i>
                        <h3 class="text-muted mt-5">Upload your profile photo</h3>
                        <button class="btn btn-primary my-2" id="imgButton" onclick="logoUpload()">Choose a file</button>
                        <form method="post" action="{{route('sp.account.photo.store')}}"  enctype="multipart/form-data">
                            {{csrf_field()}}
                            <input type="file" class="d-none" name="image" id="image">
                            <button class="btn btn-sm px-5 btn-primary my-2" style="display: none" id="imgButton2">Save</button>
                        </form>
                        <p>PNG, JPG or GIF, max. 3MB</p>

                    </div>
                    <div class="col-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-6">
                                        <img class="user-avatar rounded-circle" src="images/admin.jpg" alt="User Avatar">
                                    </div>
                                    <div class="col-6">
                                        <p class="text-muted rule-pic">Example of a good photo</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <p class="text-success text-success1">How to choose the right photo</p>
                        <p class="my-0 rule-pic">No sunglasses</p>
                        <p class="my-0 rule-pic">Facing the camera</p>
                        <p class="my-0 rule-pic">You alone</p>
                        <p class="my-0 rule-pic">Clear and bright</p>
                      

                    </div>
                </div>
            </div>
        </div>

    </div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script>

        // image upload file open
        function logoUpload() {
            jQuery("#image").click();
        }

        // Function to preview image after validation
        $(function () {
            jQuery("#image").change(function () {
                var file = this.files[0];
                var imagefile = file.type;
                var match = ["image/jpeg", "image/png", "image/jpg"];
                if (!((imagefile == match[0]) || (imagefile == match[1]) || (imagefile == match[2]))) {
                    alert("only jpeg, jpg and png Images type allowed");
                    return false;
                }
                else {
                    var reader = new FileReader();
                    reader.onload = imageIsLoaded;
                    reader.readAsDataURL(this.files[0]);
                }
            });
        });

        function imageIsLoaded(e) {
            jQuery('#previewLogo').attr('src', e.target.result).css("display","block");
            jQuery("#imgButton").hide();
            jQuery("#imgButton2").show();
        }
        $(document).ready(function(){
  $("#imgButton").click(function(){
       $("#user").hide();
  });
});
    </script>


@endsection