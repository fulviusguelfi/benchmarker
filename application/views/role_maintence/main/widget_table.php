<?php
$this->table->set_template([
    'table_open' => '<table class="table table-striped table-bordered">',
    'thead_open' => '<thead>',
    'thead_close' => '</thead>',
    'heading_row_start' => '<tr>',
    'heading_row_end' => '</tr>',
    'heading_cell_start' => '<th>',
    'heading_cell_end' => '</th>',
    'tbody_open' => '<tbody>',
    'tbody_close' => '</tbody>',
    'row_start' => '<tr>',
    'row_end' => '</tr>',
    'cell_start' => '<td>',
    'cell_end' => '</td>',
    'row_alt_start' => '<tr>',
    'row_alt_end' => '</tr>',
    'cell_alt_start' => '<td>',
    'cell_alt_end' => '</td>',
    'table_close' => '</table>'
]);
$this->table->set_caption(($list_caption ?? ''));
$this->table->set_heading(['#', 'Name', '']);
$this->table->set_empty('&nbsp;');
$this->table_element->add_element_anchor($lista, 'name', false, 'teste/teste', null, []);
$this->table_element->add_element_anchor($lista, 'actions', false, 'role/modify', '<i class="btn-icon-only icon-edit"></i>', ['class'=>'btn btn-warning btn-small btn-in-table'], 'id');
$this->table_element->add_element_anchor($lista, 'actions', true, 'role/remove', '<i class="btn-icon-only icon-remove"></i>', ['class'=>'btn btn-danger btn-small btn-in-table'], 'id');
?>
<!-- /widget -->
<div class="widget widget-table action-table">
    <div class="widget-header"> <i class="icon-th-list"></i>
        <h3><?= ($list_title ?? '') ?></h3>
    </div>
    <!-- /widget-header -->
    <div class="widget-content">
        <?= $this->table->generate($lista) ?>
    </div>
    <!-- /widget-content --> 
</div>
