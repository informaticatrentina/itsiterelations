{*$extensions|attribute('show')*}

<div class="row">
    <div class="col-md-4">
        <form>
            <div class="form-group">
                <label for="extensions_list">{'Extensions'|i18n( 'design/standard/itsiterelations' )}</label>
                <select id="extensions_list" class="form-control">

                </select>
            </div>
        </form>
    </div>
    <div class="col-md-8">
        <h3>
            {'Dependencies'|i18n( 'design/standard/itsiterelations' )}
        </h3>
        <ul id="extension_dependencies">
            
        </ul>
    </div>
</div>

<script>
    var extensions = {$extensions};
    {literal}
        $.each( extensions, function( key, value ) {
            $("#extensions_list").append($("<option></option>")
                                 .attr("value",value['Extension'])
                                 .text(value['Extension']));
        });
        
        // Selezione dell'estensione da controllare
        $('#extensions_list').on('change', function () {
            var _selected_ext = 'unknown';
            var _ext_name = $(this).val();
            
            $.each( extensions, function( key, _ext ) {
                if( _ext['Extension'] === _ext_name ){
                    _selected_ext = _ext;
                }
            });
            
            $('#extension_dependencies').html('');
            $.each( _selected_ext['Dependencies'], function( _ext, _version ) {
                $('#extension_dependencies').append('<li><b>' + _ext + '</b> version: <b>' + _version + '</b></li>');
                
            });
        });
    {/literal}
</script>