@extends('admin.layout.master')                


@section('main_content')
<style type="text/css">
.box {
    background: linear-gradient(to bottom, #009999 0%, #666699 100%);
    border-radius: 6px
    transition-property: background, border-radius;
    transition-duration: 1s;
    transition-timing-function: linear;
  }
  .box:hover {
    background: linear-gradient(to bottom, #009999 12%, #66ccff 100%);
    border-radius: 50%;
  }

</style>

                <!-- BEGIN Page Title -->
                <div class="page-title">
                    <div>
                        <h1><i class="fa fa-dashboard"></i> Dashboard</h1>
                         
                    </div>
                </div>
                <!-- END Page Title -->

                <!-- BEGIN Breadcrumb -->
                <div id="breadcrumbs">
                    <ul class="breadcrumb">
                        <li class="active"><i class="fa fa-home"></i> Home</li>

                    </ul>
                </div>
                <!-- END Breadcrumb -->
                
                <!-- BEGIN Tiles -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
            
                         @if(isset($arr_final_tile) && sizeof($arr_final_tile)>0)
                           <?php
                                    $i = 0;
                                    $total_color_shades = sizeof($arr_tile_color);
                           ?>      
                           @foreach($arr_final_tile as $key => $data)   
                              
                                 <div class="col-md-2">
                                    <a class="tile {{ $arr_tile_color[$i] }} box" href="{{ $admin_url_path.'/'.$data['module_slug'] }}">
                                        <div class="img img-center">

                                            <i class="fa fa-{{ $data['css_class'] or 'star-o' }}"></i>

                                        </div>
                                        <p class="title text-center">{{ $data['module_title'] or 'NA' }}</p>
                                    </a>
                                 </div>
                                <?php 
                                    $i++;
                                    if($i == $total_color_shades)
                                    {
                                        $i = 0;
                                    }
                                ?> 
                              
                            @endforeach
                        @endif
                                       
                        </div>
                    </div>
                    
                
@stop                    