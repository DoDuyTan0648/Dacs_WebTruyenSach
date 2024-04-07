<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DanhmucTruyen;
use App\Models\Truyen;
use App\Models\Chapter;
use App\Models\Theloai;
use App\Models\ThuocDanh;
use App\Models\ThuocLoai;
use Storage;
use App\Models\Info;
class IndexController extends Controller
{
    public function timkiem_ajax(Request $request){
        $data = $request->all();

        if($data['keywords']){

            $truyen = Truyen::where('tinhtrang',0)->where('tentruyen','LIKE','%'.$data['keywords'].'%')->get();

            $output = '
                <ul class="dropdown-menu" style="display:block;">'
            ;

            foreach($truyen as $key => $tr){
             $output.= '
                <li class="li_timkiem_ajax"><a href="#">'.$tr->tentruyen.'</a></li>';
            }

            $output .= '</ul>';
            echo $output;
     }


    }
    public function home(){
        $info = Info::find(1);
        $title = $info->tieude;
        //seo
        $meta_desc = $info->mota;
        $meta_keywords = 'sachtruyen247, doc truyen tranh, doc truyen trinh tham, đọc truyện tranh';
        $url_canonical = \URL::current();
        $og_image = url('public/uploads/logo/'.$info->logo);
        $link_icon = url('public/uploads/logo/'.$info->logo);
        //end seo
    	$theloai = Theloai::orderBy('id','DESC')->get();

    	$slide_truyen = Truyen::with('thuocnhieudanhmuctruyen','thuocnhieutheloaitruyen')->orderBy('id','DESC')->where('kichhoat',0)->take(8)->get();

    	$danhmuc = DanhmucTruyen::orderBy('id','DESC')->get();
    	$truyen = Truyen::with('thuocnhieudanhmuctruyen','thuocnhieutheloaitruyen')->orderBy('id','DESC')->where('kichhoat',0)->paginate(12);
    	return view('pages.home')->with(compact('danhmuc','truyen','theloai','slide_truyen','info','title','meta_desc','meta_keywords','url_canonical','og_image','link_icon'));
    }
    public function truyentranh(){
        $info = Info::find(1);
        $title = $info->tieude;
        //seo
        $meta_desc = $info->mota;
        $meta_keywords = 'sachtruyen247, doc truyen tranh, doc truyen trinh tham, đọc truyện tranh';
        $url_canonical = \URL::current();
        $og_image = url('public/uploads/logo/'.$info->logo);
        $link_icon = url('public/uploads/logo/'.$info->logo);
        //end seo
        $theloai = Theloai::orderBy('id','DESC')->get();

        $slide_truyen = Truyen::with('thuocnhieudanhmuctruyen','thuocnhieutheloaitruyen')->where('loaitruyen','=','truyentranh')->orderBy('id','DESC')->where('kichhoat',0)->take(8)->get();

        $danhmuc = DanhmucTruyen::orderBy('id','DESC')->get();

        $truyen = Truyen::with('thuocnhieudanhmuctruyen','thuocnhieutheloaitruyen')->where('loaitruyen','=','truyentranh')->orderBy('id','DESC')->where('kichhoat',0)->paginate(12);

        return view('pages.truyentranh.home')->with(compact('danhmuc','truyen','theloai','slide_truyen','info','title','meta_desc','meta_keywords','url_canonical','og_image','link_icon'));
    }

    public function danhmuc($slug){
        $info = Info::find(1);
        

    	$theloai = Theloai::orderBy('id','DESC')->get();
    	$danhmuc = DanhmucTruyen::orderBy('id','DESC')->get();

    	
        $slide_truyen = Truyen::with('thuocnhieudanhmuctruyen','thuocnhieutheloaitruyen')->orderBy('id','DESC')->where('kichhoat',0)->take(8)->get();

    	$danhmuc_id = DanhmucTruyen::where('slug_danhmuc',$slug)->first();
        $danhmuctruyen = DanhmucTruyen::find($danhmuc_id->id);
        // dd($danhmuctruyen->nhieutruyen);
        $nhiutruyen = [];
        foreach($danhmuctruyen->nhieutruyen as $danh){
            $nhiutruyen[] = $danh->id;
        }
        // dd($danhmuc);
       
        //seo
        $meta_desc = $danhmuc_id->mota;
        $meta_keywords = $danhmuc_id->tukhoa;
        $url_canonical = \URL::current();
        $og_image = url('public/uploads/danhmuc/'.$danhmuc_id->hinhanh);
         $link_icon = url('public/uploads/danhmuc/'.$danhmuc_id->hinhanh);
        //end seo
        
        $title = $danhmuc_id->tendanhmuc;

    	$tendanhmuc = $danhmuc_id->tendanhmuc;

    	$truyen = Truyen::with('thuocnhieudanhmuctruyen','thuocnhieutheloaitruyen')->orderBy('id','DESC')->where('kichhoat',0)->whereIn('id',$nhiutruyen)->paginate(12);

    	return view('pages.danhmuc')->with(compact('danhmuc','truyen','tendanhmuc','theloai','slide_truyen','info','title','meta_desc','meta_keywords','url_canonical','og_image','link_icon'));
    }
    public function theloai($slug){
        $info = Info::find(1);
    	$theloai = Theloai::orderBy('id','DESC')->get();
    	$danhmuc = DanhmucTruyen::orderBy('id','DESC')->get();
    	
        $slide_truyen = Truyen::with('thuocnhieudanhmuctruyen','thuocnhieutheloaitruyen')->orderBy('id','DESC')->where('kichhoat',0)->take(8)->get();

    	$theloai_id = Theloai::where('slug_theloai',$slug)->first();
        $theloaitruyen = Theloai::find($theloai_id->id);
        // dd($danhmuctruyen->nhieutruyen);
        $nhiutruyen = [];
        foreach($theloaitruyen->nhieutheloaitruyen as $the){
            $nhiutruyen[] = $the->id;
        }
        // dd($danhmuc);
        //seo
        $meta_desc = $theloai_id->mota;
        $meta_keywords = $theloai_id->tukhoa;
        $url_canonical = \URL::current();
        $og_image = url('public/uploads/theloai/'.$theloai_id->hinhanh);
         $link_icon = url('public/uploads/theloai/'.$theloai_id->hinhanh);
        //end seo
    	$tentheloai = $theloai_id->tentheloai;
        $title = $theloai_id->tentheloai;

    	$truyen = Truyen::with('thuocnhieudanhmuctruyen','thuocnhieutheloaitruyen')->orderBy('id','DESC')->where('kichhoat',0)->whereIn('id',$nhiutruyen)->paginate(12);

    	return view('pages.theloai')->with(compact('danhmuc','truyen','tentheloai','theloai','slide_truyen','info','title','meta_desc','meta_keywords','url_canonical','og_image','link_icon'));
    }
     public function xemtruyen($slug){
        $info = Info::find(1);

     	
        $slide_truyen = Truyen::with('thuocnhieudanhmuctruyen','thuocnhieutheloaitruyen')->orderBy('id','DESC')->where('kichhoat',0)->take(8)->get();
    	$theloai = Theloai::orderBy('id','DESC')->get();
     	$danhmuc = DanhmucTruyen::orderBy('id','DESC')->get();

     	$truyen = Truyen::with('thuocnhieudanhmuctruyen','thuocnhieutheloaitruyen')->where('slug_truyen',$slug)->where('kichhoat',0)->first();

     

        //dd($danhmuctruyen->nhieutruyen);
        $nhiutruyen = '';
        foreach($truyen->thuocnhieudanhmuctruyen as $danh){
            $nhiutruyen = $danh->id;
        }

        //seo
        $meta_desc = $truyen->tomtat;
        $meta_keywords = $truyen->tukhoa;
        $url_canonical = \URL::current();
        $og_image = url('public/uploads/truyen/'.$truyen->hinhanh);
          $link_icon = url('public/uploads/truyen/'.$truyen->hinhanh);
        //end seo
        $title = $truyen->tentruyen;

     	$chapter = Chapter::with('truyen')->orderBy('id','ASC')->where('truyen_id',$truyen->id)->get();
        
        
     	$chapter_dau = Chapter::with('truyen')->orderBy('id','ASC')->where('truyen_id',$truyen->id)->first();

        $chapter_moinhat = Chapter::with('truyen')->orderBy('id','DESC')->where('truyen_id',$truyen->id)->first();

     	$cungdanhmuc = DanhmucTruyen::with('nhieutruyen')->where('id',$nhiutruyen)->take(16)->get();

        $truyentranh_sidebar = Truyen::with('thuocnhieudanhmuctruyen','thuocnhieutheloaitruyen')->where('loaitruyen','=','truyentranh')->take(10)->get();
        // $truyen = $cungdanhmuc->nhieutruyen;
        // echo '<pre>';
        // print_r($cungdanhmuc);
        // echo '</pre>';
    	return view('pages.truyen')->with(compact('truyentranh_sidebar','danhmuc','truyen','chapter','cungdanhmuc','chapter_dau','theloai','slide_truyen','info','title','meta_desc','meta_keywords','url_canonical','og_image','link_icon','chapter_moinhat'));
    }
    public function xemchapter($slug_truyen,$slug){
        $info = Info::find(1);
    	
        $slide_truyen = Truyen::with('thuocnhieudanhmuctruyen','thuocnhieutheloaitruyen')->orderBy('id','DESC')->where('kichhoat',0)->take(8)->get();
    	$theloai = Theloai::orderBy('id','DESC')->get();
    	$danhmuc = DanhmucTruyen::orderBy('id','DESC')->get();

		
    	$truyen = Chapter::where('slug_chapter',$slug)->first();

		//breadcrumb
		$truyen_breadcrumb = Truyen::with('danhmuctruyen','theloai')->where('id',$truyen->truyen_id)->first();
		//end breadcrumb	
		
    	$chapter = Chapter::with('truyen')->where('slug_chapter',$slug)->where('truyen_id',$truyen->truyen_id)->first();

        $title = $chapter->tieude;
        //seo
        $meta_desc = $chapter->tomtat;
        $meta_keywords = '';
        $url_canonical = \URL::current();
        $og_image = url('public/uploads/truyen/'.$truyen_breadcrumb->hinhanh);
        $link_icon = url('public/uploads/truyen/'.$truyen_breadcrumb->hinhanh);
        //end seo
    	$all_chapter = Chapter::with('truyen')->orderBy('id','ASC')->where('truyen_id',$truyen->truyen_id)->get();


    	$next_chapter = Chapter::where('truyen_id',$truyen->truyen_id)->where('id','>',$chapter->id)->min('slug_chapter');

    	$max_id =  Chapter::where('truyen_id',$truyen->truyen_id)->orderBy('id','DESC')->first();
    	$min_id =  Chapter::where('truyen_id',$truyen->truyen_id)->orderBy('id','ASC')->first();
    	
    	$previous_chapter = Chapter::where('truyen_id',$truyen->truyen_id)->where('id','<',$chapter->id)->max('slug_chapter');

    	return view('pages.chapter')->with(compact('danhmuc','chapter','all_chapter','next_chapter','previous_chapter','max_id','min_id','theloai','truyen_breadcrumb','slide_truyen','info','title','meta_desc','meta_keywords','url_canonical','og_image','link_icon'));
    }
    public function xemtruyentranh($slug_truyen,$slug){
        $info = Info::find(1);
        
        $slide_truyen = Truyen::with('thuocnhieudanhmuctruyen','thuocnhieutheloaitruyen')->orderBy('id','DESC')->where('kichhoat',0)->take(8)->get();

        $theloai = Theloai::orderBy('id','DESC')->get();
        $danhmuc = DanhmucTruyen::orderBy('id','DESC')->get();

        
        $truyen = Chapter::where('slug_chapter',$slug)->first();

        //breadcrumb
        $truyen_breadcrumb = Truyen::with('thuocnhieudanhmuctruyen','thuocnhieutheloaitruyen')->where('id',$truyen->truyen_id)->first();
        //end breadcrumb    
        
        $chapter = Chapter::with('truyen')->where('slug_chapter',$slug)->where('truyen_id',$truyen->truyen_id)->first();

        $title = $chapter->tieude;
        //seo
        $meta_desc = $chapter->tomtat;
        $meta_keywords = '';
        $url_canonical = \URL::current();
        $og_image = url('public/uploads/truyen/'.$truyen_breadcrumb->hinhanh);
        $link_icon = url('public/uploads/truyen/'.$truyen_breadcrumb->hinhanh);
        //end seo
        $all_chapter = Chapter::with('truyen')->orderBy('id','ASC')->where('truyen_id',$truyen->truyen_id)->get();

        $next_chapter = Chapter::where('truyen_id',$truyen->truyen_id)->where('id','>',$chapter->id)->min('slug_chapter');

        $max_id =  Chapter::where('truyen_id',$truyen->truyen_id)->orderBy('id','DESC')->first();
        $min_id =  Chapter::where('truyen_id',$truyen->truyen_id)->orderBy('id','ASC')->first();
        
        $previous_chapter = Chapter::where('truyen_id',$truyen->truyen_id)->where('id','<',$chapter->id)->max('slug_chapter');
      

        return view('pages.truyentranh.xemtruyen')->with(compact('danhmuc','chapter','all_chapter','next_chapter','previous_chapter','max_id','min_id','theloai','truyen_breadcrumb','slide_truyen','info','title','meta_desc','meta_keywords','url_canonical','og_image','link_icon'));
    }
    public function show_tranh(Request $request){
        $data = $request->all();
        $output = '';
        // nội dung truyện tranh
        $folder = $data['slug_chapter'];

        $contents = collect(Storage::disk('google')->listContents('/', true));

        $dir = $contents->where('type', '=', 'dir')
                ->where('filename', '=', $folder)
                ->first(); // There could be duplicate directory names!

        if ( ! $dir) {
            return 'No such folder!';
        }

        $files = collect(Storage::disk('google')->listContents($dir['path'], false))
                ->where('type', '=', 'file')->sortBy('filename');
        foreach($files as $key => $file){
            $output.='<p class="file-truyentranh"><img src="https://drive.google.com/uc?id='.$file['basename'].'" class="img-responsive" width="100%"></p>';
        }
        echo $output;
    }
    public function timkiem(Request $request){
        $data = $request->all();
        $info = Info::find(1);
        $title = 'Tìm kiếm';
        //seo
        $meta_desc = 'Tìm kiếm';
        $meta_keywords = 'Tìm kiếm';
        $url_canonical = \URL::current();
        $og_image = url('public/uploads/logo/'.$info->logo);
         $link_icon = url('public/uploads/logo/'.$info->logo);
        //end seo
    	
        $slide_truyen = Truyen::with('thuocnhieudanhmuctruyen','thuocnhieutheloaitruyen')->orderBy('id','DESC')->where('kichhoat',0)->take(8)->get();
    	$theloai = Theloai::orderBy('id','DESC')->get();
    	$danhmuc = DanhmucTruyen::orderBy('id','DESC')->get();

    	$tukhoa = $data['tukhoa'];
    	$truyen = Truyen::with('thuocnhieudanhmuctruyen','thuocnhieutheloaitruyen')->where('tentruyen','LIKE','%'.$tukhoa.'%')->orWhere('tomtat','LIKE','%'.$tukhoa.'%')->orWhere('tacgia','LIKE','%'.$tukhoa.'%')->paginate(12);

    	return view('pages.timkiem')->with(compact('danhmuc','truyen','theloai','slide_truyen','tukhoa','info','title','meta_desc','meta_keywords','url_canonical','og_image','link_icon'));
    }
    public function tag($tag){
        $info = Info::find(1);
        $title = 'Tìm kiếm tags';
        //seo
        $meta_desc = 'Tìm kiếm tags';
        $meta_keywords = 'Tìm kiếm tags';
        $url_canonical = \URL::current();
        $og_image = url('public/uploads/logo/'.$info->logo);
         $link_icon = url('public/uploads/logo/'.$info->logo);
        //end seo
        
        $slide_truyen = Truyen::with('thuocnhieudanhmuctruyen','thuocnhieutheloaitruyen')->orderBy('id','DESC')->where('kichhoat',0)->take(8)->get();
        $theloai = Theloai::orderBy('id','DESC')->get();
        $danhmuc = DanhmucTruyen::orderBy('id','DESC')->get();

       
        $tags = explode("-", $tag);
       
        $truyen = Truyen::with('thuocnhieudanhmuctruyen','thuocnhieutheloaitruyen')->where(
            function ($query) use($tags) {
                for ($i = 0; $i < count($tags); $i++){
                    $query->orwhere('tukhoa', 'LIKE',  '%' . $tags[$i] .'%');
                }
            })->paginate(12);

        return view('pages.tag')->with(compact('danhmuc','truyen','theloai','slide_truyen','tag','info','title','meta_desc','meta_keywords','url_canonical','og_image','link_icon'));
    }
}
