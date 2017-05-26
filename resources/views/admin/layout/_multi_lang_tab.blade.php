@if(isset($arr_lang) && sizeof($arr_lang)>0)
    @foreach($arr_lang as $lang)
        <li class="{{ $lang['locale']=='en'?'active':'' }}">
            <?php 
                $is_linked_enabled = $lang['locale']=='en'?TRUE:FALSE;
            ?>
        	<a href="#{{$lang['locale']}}" 
                    @if(isset($edit_mode) && $edit_mode==TRUE)
                        data-toggle="tab"
                    @else
                       {{ $lang['locale']=='en'?'data-toggle="tab"':'' }} 
                    @endif
                > 
        		<i class="fa fa-home"></i> 
        		{{$lang['title']}} 
        	</a>
        </li>
    @endforeach
@endif