<?php
$results['sEcho'] = $sEcho;
$results['iTotalRecords'] = $results['iTotalDisplayRecords'] = $iTotalRecords;


if(count($test)){
	$i=0;
	foreach($test as $row){
		//masukan data yg ditampung json kedalam array
		//$menu_name = $row->mnme;
		$menu_name = '';
		$menu_name .= ($row->mstat==FALSE) ? $row->mnme . ' <small class="text-muted">(Inactive)</small>' : $row->mnme;
		$menu_name .= '<div class="small action" id="qe-' . $row->mid . '">';
		if($row->mpar != FALSE) {
			/*if(in_array('u', $this->sso->access)){*/
				$menu_name .= anchor('sso/menus/form/' . $row->mid, '<span class="fa fa-edit"></span>' . nbs() . 'Edit', 'title="Edit menu"') . nbs(2) . '<span class="text-muted small">|</span>' . nbs(2);
				$menu_name .= anchor('#', '<i class="fa fa-pencil"></i>  Quick Edit', 'class="quick-edit" id="qt-' . $row->mid . '" title="Fast edit menu"') . nbs(2) . '<span class="text-muted small">|</span>' . nbs(2);
			/*}
			if (in_array('d', $this->sso->access))*/
				$menu_name .= anchor('#', '<i class="fa fa-trash"></i>' . nbs() . 'Delete', 'class="text-danger" title="Delete menu" data-toggle="modal" data-target="#confirm-delete" data-href="' . base_url('sso/menus/erase/' . $row->mid) . '"');
		}
		$menu_name .= '</div>';
		$menu_name .= '<div class="quick-form" id="qf-' . $row->mid . '">';
		$menu_name .= form_open('sso/menus/act', 'class="form-horizontal"', array('mid' => $row->mid, 'quick' => TRUE));
		$menu_name .= '<div class="form-group">';
		$menu_name .= form_label('Name', 'mnme', array('class' => 'col-xs-4 col-md-2 control-label'));
		$menu_name .= '<div class="col-xs-4 col-md-10">';
		$menu_name .= form_input('mnme', str_replace('_', NULL, $row->mnme), 'class="input-sm form-control" id="mnme" placeholder="Menu name"');
		$menu_name .= '</div>';
        $menu_name .= '</div>';
		$menu_name .= '<div class="form-group">';
        $menu_name .= '<div class="col-sm-offset-2 col-sm-10">';
		$menu_name .= '<button type="submit" class="btn btn-sm btn-primary">Update menu</button>';
		$menu_name .= '<button type="button" class="btn btn-sm btn-default" id="cqe-'. $row->mid . '">Cancel</button>';
        $menu_name .= '</div>';
        $menu_name .= '</div>';
		$menu_name .= form_close();
        $menu_name .= '</div>';

		$menu_icon = '<span class="fa'.$row->mico.'"></span>';
		$menu_link = base_url($row->mlnk);
		$menu_update = mdate('%F %j, %Y on %H:%i', strtotime($row->ud)) . br() . '<span class="small text-muted">' . time_elapsed($row->ud) . nbs() . '<em>by</em>' . nbs() . $row->ufnme . '</span>';
		$menu_status = $row->mstat;
		$menu_id = $row->mid;
		/*$action = '<center>
					<a href="'.base_url().'category/edit/'.$row->category_id.'" title="Edit"><i class="glyphicon glyphicon-pencil"></i></a>&nbsp;
					<a href="'.base_url().'category/delete/'.$row->category_id.'" title="Delete" onclick="return confirm(\'Are you sure want to delete this data?\')"><i class="glyphicon glyphicon-trash"></i></a></center>';*/

		$results['aaData'][$i] = array(
				$menu_name,
				$menu_icon,
				$menu_link,
				$menu_update,
				$menu_status,
				$menu_id
			);
		++$i;
	}
} else {
	//jika data kosong, sistem iddle
	for($i=0;$i<6;++$i) {
		$results['aaData'][0][$i] = '';
	}
}
print($callback.'('.json_encode($results).')');