@extends('../layout')

{{-- @section('slide')

  @include('pages.slide')

@endsection --}}

@section('content')



<nav aria-label="breadcrumb">

  <ol class="breadcrumb">

    <li class="breadcrumb-item"><a href="{{url('/')}}">Trang chủ</a></li>
    @foreach($truyen_breadcrumb->thuocnhieutheloaitruyen as $key => $breadcrumb_theloai)
    <li class="breadcrumb-item"><a href="{{url('the-loai/'.$breadcrumb_theloai->slug_theloai)}}">{{$breadcrumb_theloai->tentheloai}}</a></li>
    @endforeach
    @foreach($truyen_breadcrumb->thuocnhieudanhmuctruyen as $key => $breadcrumb_danh)
     <li class="breadcrumb-item"><a href="{{url('danh-muc/'.$breadcrumb_danh->slug_danhmuc)}}">{{$breadcrumb_danh->tendanhmuc}}</a></li>
    @endforeach

    <li class="breadcrumb-item"><a href="{{url('xem-truyen/'.$chapter->truyen->slug_truyen)}}">{{$chapter->truyen->tentruyen}}</a></li>

    <li class="breadcrumb-item active" aria-current="page">{{$chapter->tieude}}</li>

  </ol>

</nav>



<div class="row">

	<div class="col-md-12">

		<h4>{{$chapter->truyen->tentruyen}}</h4>

		<p>Chương hiện tại : {{$chapter->tieude}}</p>

		<div class="col-md-5">



            <style type="text/css">

              .isDisabled {

                color: currentColor;

                 pointer-events: none;

                opacity: 0.5;

                text-decoration: none;

              }

            .noidungchuong {
          padding: 20px;
          background: #fff;
          line-height: 40px !important;
          font-size: 25px !important;
          font-family: "Palatino Linotype","Arial","Times New Roman",sans-serif !important;
      }

            </style>



          		<div  class="form-group">



                                  <label for="exampleInputEmail1">Chọn chương</label>



                                   <p> <a class="btn btn-primary {{$chapter->id==$min_id->id ? 'isDisabled' : ''}}" href="{{url('xem-truyen-tranh/'.$chapter->truyen->slug_truyen.'/'.$previous_chapter)}}">Tập Trước</a></p>



                                  <select name="select-chapter" class="custom-select select-chapter">

                                    @foreach($all_chapter as $key => $chap)

                                    <option value="{{url('xem-truyen-tranh/'.$chap->truyen->slug_truyen.'/'.$chap->slug_chapter)}}">{{$chap->tieude}}</option>

                                    @endforeach

                                  </select>



                                   <p class="mt-4"><a class="btn btn-primary {{$chapter->id==$max_id->id ? 'isDisabled' : ''}} "   href="{{url('xem-truyen-tranh/'.$chapter->truyen->slug_truyen.'/'.$next_chapter)}}">Tập Sau</a></p>

                                  </div>
                              
                                  <div class="waiting"></div>

                            </div>

                 

                  <div class="noidungchuong">
               

                
                    <form>
                      @csrf
                    <input type="hidden" value="showtranh" class="showtranh">
                    <input type="hidden" value="{{$chapter->slug_chapter}}" class="slug_chapter">
                    <div id="show_tranh"></div>
                    </form>
                   
                    <div id='loader' style='display: none;'>
                      <div class="spinner-grow text-primary" role="status">
                        <span class="sr-only">Loading...</span>
                      </div>
                      <div class="spinner-grow text-secondary" role="status">
                        <span class="sr-only">Loading...</span>
                      </div>
                      <div class="spinner-grow text-success" role="status">
                        <span class="sr-only">Loading...</span>
                      </div>
                      <div class="spinner-grow text-danger" role="status">
                        <span class="sr-only">Loading...</span>
                      </div>
                      <div class="spinner-grow text-warning" role="status">
                        <span class="sr-only">Loading...</span>
                      </div>
                      <div class="spinner-grow text-info" role="status">
                        <span class="sr-only">Loading...</span>
                      </div>
                      <div class="spinner-grow text-light" role="status">
                        <span class="sr-only">Loading...</span>
                      </div>
                      <div class="spinner-grow text-dark" role="status">
                        <span class="sr-only">Loading...</span>
                      </div>
                      <p class="text text-primary">Đang load ảnh truyện xin vui lòng chờ xíu nhé...</p>
                    </div>
              
                {{--   @foreach($files as $key => $file)
                    <p class="file-truyentranh"><img src="https://drive.google.com/uc?id={{$file['basename']}}" class="img-responsive" width="100%"></p>
                  @endforeach
                   --}}
                       



                  </div>



                  <div class="col-md-5">

                 <div  class="form-group">



                                  <label for="exampleInputEmail1">Chọn chương</label>



                                   <p> <a class="btn btn-primary {{$chapter->id==$min_id->id ? 'isDisabled' : ''}}" href="{{url('xem-truyen-tranh/'.$previous_chapter)}}">Tập Trước</a></p>



                                  <select name="select-chapter" class="custom-select select-chapter">

                                    @foreach($all_chapter as $key => $chap)

                                    <option value="{{url('xem-truyen-tranh/'.$chapter->truyen->slug_truyen.'/'.$chap->truyen->slug_truyen.'/'.$chap->slug_chapter)}}">{{$chap->tieude}}</option>

                                    @endforeach

                                  </select>




                                   <p class="mt-4"><a class="btn btn-primary {{$chapter->id==$max_id->id ? 'isDisabled' : ''}} "   href="{{url('xem-truyen-tranh/'.$chapter->truyen->slug_truyen.'/'.$next_chapter)}}">Tập Sau</a></p>

                                  </div>



                  </div>

                   <h3>Lưu và chia sẻ truyện :  </h3>

                         <div class="fb-share-button" data-href="{{$url_canonical}}" data-layout="button_count" data-size="large"><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u={{$url_canonical}}" class="fb-xfbml-parse-ignore">Chia sẻ</a></div>
                         
                          <div class="row">
                            <div class="col-md-12"> <div data-width="100%" class="fb-comments" data-href="{{$url_canonical}}" data-width="" data-numposts="10"></div></div>
                          </div>

                         



	</div>



</div>



@endsection