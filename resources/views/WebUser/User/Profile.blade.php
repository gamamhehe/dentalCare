@extends('admin.masterUser')
@section('content')
    <div class="top">
        <!-- start menu -->
      <div class="container" style="background-color: whitesmoke;"><div class="container" style="margin-top: 30px;margin-bottom: 50px;">
              <div class="row">
                  <div class="col-sm-8 push-sm-2 text-xs-center Bacsititle">
                      <h3><strong>CÔNG NGHỆ PHẪU THUẬT THẨM MỸ HOT NHẤT</strong></h3>
                      <div class="gach">
                          <div class="tron"></div>
                      </div>
                  </div>
              </div>
              <div class="row">
                  <div class="col-sm-3 motmon">
                      <img src="/assets/images/HomePage/implent.jpg" alt="" class="img-fluid img-responsive">
                      <div class="tieude"><a href="">Trồng răng implent</a></div>
                      <div>Trồng implent với công nghệ <a href="#"> ...  </a></div>
                  </div>
                  <div class="col-sm-3 motmon">
                      <img src="/assets/images/HomePage/rangsu.jpg" alt="" class="img-fluid img-responsive">
                      <div class="tieude"><a href="">Làm răng sứ</a></div>
                      <div>Răng sứ được nhập khẩu<a href="#"> ...  </a></div>
                  </div>
                  <div class="col-sm-3 motmon">
                      <img src="/assets/images/HomePage/taytrangrag.jpg" alt="" class="img-fluid img-responsive">
                      <div class="tieude"><a href="">Tẩy Trắng Răng</a></div>
                      <div>Quy trình tẩy trắng<a href="#"> ... </a></div>
                  </div>
                  <div class="col-sm-3 motmon">
                      <img src="/assets/images/HomePage/nienrang.jpg" alt="" class="img-fluid img-responsive">
                      <div class="tieude"><a href="">Niền Răng</a></div>
                      <div>Niền răng được phân loại<a href="#"> ... </a></div>
                  </div>
              </div>
          </div></div>
        <!-- end menu -->

    </div>
@endsection
@section('js')
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        $(document).ready(function() {
            <?php if (Session::has('success')): ?>
            swal("Bài viết chưa được tạo!", "", "error");
            <?php endif ?>

            function xxx(evt,sel){
                var check  = document.getElementById('thumbnail').value;
                if(check.length!= 0){
                    swal("Hết nulll nhaaa!", "", "error");
                }
            }
        });
        $('#lfm').filemanager('image');
        $(window).on('load', function () {
            $(document).ready(function () {
                var check  = document.getElementById('thumbnail').value;
                if(check.length !=0){
                    alert("DKM");
                }
                Page.initTinyMCE();
                Page.initLFM();

            });
        });
        function validateQuestionBeforeCreate(evt,sel){
            // swal("Bài viết chưa được tạo!", "", "error");

            var title = document.getElementById('title').value;
            var img = document.getElementById('thumbnail').value;
            var textarea  =tinyMCE.get('tinyMCE').getContent({format: 'text'});

            if($.trim(title) == ''){
                swal("Vui lòng điền tiêu đề!", "", "error");
            }else if($.trim(img) == ''){
                swal("Vui lòng chọn ảnh!", "", "error");

            }else if($.trim(textarea) == ''){
                swal("Vui lòng thêm nội dung bài viết!", "", "error");
            }
            else{
                document.getElementById('createNews').submit();
            }
        }

    </script>
@endsection
  