<template>
    <div class="box">
    <div class="box-header">
        <h3 class="box-title">Hover Data Table</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap"><div class="row"><div class="col-sm-6"></div><div class="col-sm-6"></div></div><div class="row"><div class="col-sm-12">
            <table id="example2" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
        <thead>
            <tr role="row">
                <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending">Rendering engine</th>
                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">Browser</th>
                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Platform(s)</th>
                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Engine version: activate to sort column ascending">Engine version</th>
                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending">CSS grade</th>
            </tr>
        </thead>
        <tbody>
            <tr role="row" class="odd">
                <td class="sorting_1">Gecko</td>
                <td>Firefox 1.0</td>
                <td>Win 98+ / OSX.2+</td>
                <td>1.7</td>
                <td>A</td>
            <tr role="row" class="even">
                <td class="sorting_1">Gecko</td>
                <td>Mozilla 1.0</td>
                <td>Win 95+ / OSX.1+</td>
                <td>1</td>
                <td>A</td>
            </tr></tbody>
            <tfoot>
            <tr><th rowspan="1" colspan="1">Rendering engine</th><th rowspan="1" colspan="1">Browser</th><th rowspan="1" colspan="1">Platform(s)</th><th rowspan="1" colspan="1">Engine version</th><th rowspan="1" colspan="1">CSS grade</th></tr>
            </tfoot>
        </table></div></div>

        <paginator></paginator>
        </div>
    </div>
    <!-- /.box-body -->
    </div>

</template>
