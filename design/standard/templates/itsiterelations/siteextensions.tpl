<div class="row">
    <div class="col-md-4">
        <form>
            <div class="btn-group" data-toggle="buttons">
                <label id="extensions" class="btn btn-success">
                    <input type="radio" name="options" id="extensions_view" autocomplete="off" checked> 
                    <i class="fa fa-code"></i>
                    {'Extensions'|i18n( 'design/standard/itsiterelations' )}
                </label>
                <label id="siteaccess" class="btn btn-success">
                    <input type="radio" name="options" id="siteaccess_view" autocomplete="off"> 
                    <i class="fa fa-globe"></i>
                    {'Sites'|i18n( 'design/standard/itsiterelations' )}
                </label>
            </div>

            <select id="extensions_list" class="form-control" style="display:none;">

            </select>

            <select id="site_list" class="form-control" style="display:none;">

            </select>
        </form>
    </div>
    <div class="col-md-6">
        <table id="extensions_table" class="table table-striped" style="display: none;">
            <thead>
                <tr>
                    <th class="header">{'Site'|i18n( 'design/standard/itsiterelations' )}</th>
                    <th class="header">{'Frontend'|i18n( 'design/standard/itsiterelations' )}</th>
                    <th class="header">{'Backend'|i18n( 'design/standard/itsiterelations' )}</th>
                    <th class="header">{'Debug'|i18n( 'design/standard/itsiterelations' )}</th>
                    <th class="header">{'Eng'|i18n( 'design/standard/itsiterelations' )}</th>
                    <th class="header">{'Deu'|i18n( 'design/standard/itsiterelations' )}</th>
                </tr>
            </thead>
            <tbody id="extensions_tbody">
                
            </tbody>
        </table>
        
        <table id="site_table" class="table table-striped" style="display: none;">
            <thead>
                <tr>
                    <th class="header">{'Extension'|i18n( 'design/standard/itsiterelations' )}</th>
                    <th class="header">{'Frontend'|i18n( 'design/standard/itsiterelations' )}</th>
                    <th class="header">{'Backend'|i18n( 'design/standard/itsiterelations' )}</th>
                    <th class="header">{'Debug'|i18n( 'design/standard/itsiterelations' )}</th>
                    <th class="header">{'Eng'|i18n( 'design/standard/itsiterelations' )}</th>
                    <th class="header">{'Deu'|i18n( 'design/standard/itsiterelations' )}</th>
                </tr>
            </thead>
            <tbody id="site_tbody">
                
            </tbody>
        </table>
    </div>
</div>

<script>
    // Variabili globali
    var ezp_extensions = {$extensions};
    var site_extensions = {$siteextensions};
        
    {literal}
    // Vista per estensioni
    $('#extensions').on('click', function () {
        $("#extensions_list").html('');
        
        $.each( ezp_extensions, function( key, value ) {
            $("#extensions_list").append($("<option></option>")
                                 .attr("value",value)
                                 .text(value)); 

        });

        $("#extensions_tbody").html('');

        $("#extensions_list").show();
        $("#extensions_table").show();

        $("#site_list").hide();
        $("#site_table").hide();
    });
    
    // Vista per siteaccess
    $('#siteaccess').on('click', function () {
        $("#site_list").html('');
        
        $.each( site_extensions, function( key, value ) {
            $("#site_list").append($("<option></option>")
                                     .attr("value",value['Site'])
                                     .text(value['Site']));
        });
        
        $("#site_tbody").html('');
        
        $("#site_list").show();
        $("#site_table").show();
        
        $("#extensions_list").hide();
        $("#extensions_table").hide();
    });
    
    // Verifica se un estensione è presente
    function check_enabled(ext_list, sel_ext){
        var _fe_enabled = false;
        $.each( ext_list, function( key, _extension ) {

            if( sel_ext === _extension ){
                _fe_enabled = true;
            }
        });
        if( _fe_enabled ){
            return '<td><div class="label label-success"><i class="fa fa-check-circle"></i></div></td>';
        }
        else{
            return '<td><div class="label label-danger"><i class="fa fa-times-circle"></i></div></td>';
        }
    }
    
    // Selezione dell'estensione da controllare
    $('#extensions_list').on('change', function () {
        var _selected_extension = $(this).val();
    
        // Per ogni Sito
        $("#extensions_tbody").html('');
        $.each( site_extensions, function( key, _site ) {
            var _row = '';
            
            // Nome Sito
            _row += '<td>' + _site['Site'] + '</td>';
            
            // Front End
            _row += check_enabled(_site['FrontEndExtensions'], _selected_extension);
            
            // Back End
            _row += check_enabled(_site['AdminExtensions'], _selected_extension);
            
            // Debug
            _row += check_enabled(_site['DebugExtensions'], _selected_extension);
            
            // Eng
            _row += check_enabled(_site['EngExtensions'], _selected_extension);
            
            // Deu
            _row += check_enabled(_site['DeuExtensions'], _selected_extension);
           
           $("#extensions_tbody").append('<tr>' + _row + '</tr>');
        });
    });
    
    // Selezione del site da controllare
    $('#site_list').on('change', function () {
        var _selected_site = 'unknown';
        var _site_name = $(this).val();
        
        $.each( site_extensions, function( key, _site ) {
            if( _site['Site'] === _site_name ){
                _selected_site = _site;
            }
        });
        
        // Per il Sito Attuale
        $("#site_tbody").html('');
        $.each( ezp_extensions, function( key, _ext ) {
            var _row = '';
            
            // Nome Estensione
            _row += '<td>' + _ext + '</td>';
            
            // Front End
            _row += check_enabled(_selected_site['FrontEndExtensions'], _ext);
            
            // Back End
            _row += check_enabled(_selected_site['AdminExtensions'], _ext);
            
            // Debug
            _row += check_enabled(_selected_site['DebugExtensions'], _ext);
            
            // Eng
            _row += check_enabled(_selected_site['EngExtensions'], _ext);
            
            // Deu
            _row += check_enabled(_selected_site['DeuExtensions'], _ext);
            
           $("#site_tbody").append('<tr>' + _row + '</tr>');
        });
    });
    
    {/literal}
</script>
