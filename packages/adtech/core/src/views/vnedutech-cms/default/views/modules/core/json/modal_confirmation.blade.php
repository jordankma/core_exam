<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
  <h4 class="modal-title" id="user_delete_confirm_title">Xuất Json</h4>
</div>
{!! Form::open(array('url' => $confirm_route, 'method' => 'post', 'class' => 'bf')) !!}
<div class="modal-body">
    @if($error)
        <div>{!! $error !!}</div>
    @else
        <label>{{ Form::radio('language', 'all', true) }} Tất cả ngôn ngữ</label>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <label>{{ Form::radio('language', 'select', false) }} Tự chọn ngôn ngữ</label>
        <br><br>
        <div class="row" id="boxLocale" style="display: none">
            <label class="col-sm-3" style="padding: 0px; text-align: right">Chọn ngôn ngữ</label>
            <div class="col-sm-6">
                <select class="form-control select2" name="locale[]" id="select_locale" multiple="multiple">
                    @foreach($locales as $locale)
                        <option value="{{ $locale->alias }}">{{ $locale->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    @endif
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('adtech-core::confirm.cancel') }}</button>
  @if(!$error)
    <button type="submit" class="btn btn-success">{{ trans('adtech-core::confirm.confirm') }}</button>
  @endif
</div>
{!! Form::close() !!}

<script>
    $(function () {
        $('input[type="radio"]').on('change', function(e) {
            if (e.currentTarget.value === 'select') {
                $("#boxLocale").css('display', '');
            } else {
                $("#boxLocale").css('display', 'none');
            }
        });

        $("#select_locale").multiselect({
            enableFiltering: true,
            includeSelectAllOption: true,
            maxHeight: 800,
            dropUp: false
        });
    });
</script>
