@extends('layouts.app')

@section('content')
@include('style')
@include('header')
<?php
use Illuminate\Support\Facades\Route;
$currentPaths= Route::getFacadeRoot()->current()->uri();	
$url = URL::to("/");
$setid=1;
$setts = DB::table('settings')
		->where('id', '=', $setid)
		->get();
$default = DB::table('avig_language')
	              ->where('lang_default','=',1)
		           ->get();


$default_cnt = DB::table('avig_language')
	              ->where('lang_default','=',1)
		           ->count();
if(!empty(Cookie::get('lang'))){ $lang = Cookie::get('lang'); } else { if(!empty($default_cnt)){ $lang = $default[0]->lang_code; } else { $lang = "en"; } }
function translate_header($id,$lang) 
{					
	if($lang == "en")
	{
	$translate = DB::table('avig_translate')
		            
					->where('lang_code', '=', $lang)
					->where('id', '=', $id)
					->get();
					
		$translate_cnt = DB::table('avig_translate')
		            
					->where('lang_code', '=', $lang)
					->where('id', '=', $id)
					->count();			
	}
	else
	{
	$translate = DB::table('avig_translate')
		            
					->where('lang_code', '=', $lang)
					->where('parent', '=', $id)
					->get();
					
		$translate_cnt = DB::table('avig_translate')
		            
					->where('lang_code', '=', $lang)
					->where('parent', '=', $id)
					->count();			
	}				
	if(!empty($translate_cnt))
	{
					return $translate[0]->name;
	}
	else
	{
	  return "";
	}
}
?>



<div class="height30"></div>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"><?php echo translate_header( 811, $lang);?></div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form class="form-horizontal" role="form" method="POST" action="{{ route('password.request') }}">
                        {{ csrf_field() }}

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label"><?php echo translate_header( 430, $lang);?></label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ $email or old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label"><?php echo translate_header( 433, $lang);?></label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            <label for="password-confirm" class="col-md-4 control-label"><?php echo translate_header( 934, $lang);?></label>
                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>

                                @if ($errors->has('password_confirmation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <?php echo translate_header( 811, $lang);?>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@include('footer')
@endsection
