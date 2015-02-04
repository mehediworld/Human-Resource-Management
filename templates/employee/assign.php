<div class="hrm-update-notification"></div>
<?php
if ( hrm_current_user_role() == 'hrm_employee' ) {
    $employer_id = get_current_user_id();
} else {
    $employer_id = isset( $_REQUEST['employee_id'] ) ? trim( $_REQUEST['employee_id'] ) : '';
}
$search['leave_status'] = array(
    'type'   => 'select',
    'option' => Hrm_Leave::getInstance()->leave_status(),
);

$search['type'] = array(
    'type'  => 'hidden',
    'value' => '_search'
);

$search['table_option'] = 'hrm_leave';
$search['action']       = 'hrm_search';
echo Hrm_Settings::getInstance()->get_serarch_form( $search, 'Leave');
?>
<div id="hrm_Leave_list"></div>
<?php

$pagenum     = hrm_pagenum();
$limit       = hrm_result_limit();
if( isset( $_POST['type'] ) && ( $_POST['type'] == '_search' ) ) {
    $post         = $_POST;
    $search_satus = true;
    $results      = Hrm_Settings::getInstance()->search_query( $post, $limit, $pagenum );
} else {
    $results = Hrm_Settings::getInstance()->conditional_query_val( 'hrm_leave', $fields = '*', $compare = array( 'emp_id' => $employer_id) );
    $search_satus = false;
}

$total = $results['total_row'];
unset( $results['total_row'] );

$leave_types = Hrm_Settings::getInstance()->hrm_query('hrm_leave_type');
unset( $leave_types['total_row'] );
foreach ( $leave_types as $key => $leave_type ) {
    $leave_cat[$leave_type->id] = $leave_type->leave_type_name;
}

$users = get_users();
foreach ( $users as $key => $user ) {
    $user_info[$user->ID] = $user->display_name;
}

$work_in_week = get_option( 'hrm_work_week' );
$holidays = Hrm_Settings::getInstance()->hrm_query('hrm_holiday');
unset( $holidays['total_row'] );
$holiday_index = array();

foreach ( $holidays as $key => $holiday ) {
    $holiday_index = array_merge( $holiday_index, maybe_unserialize( $holiday->index_holiday ) );
}


foreach ( $results as $key => $value) {
    if ( !isset( $leave_cat[$value->leave_type_id] ) ) {
        continue;
    }

    $leave_action_dropdown = array(
        'class'    => 'hrm-leave-action',
        'extra'    => array(
            'data-leave_id' => $value->id,
        ),
        'option'   => hrm_Leave::getInstance()->leave_employer_status(),
        'selected' => $value->leave_status
    );

    $body[] = array(
        '<input name="hrm_check['.$value->id.']" value="" type="checkbox">',
        '<a href="#" class="hrm-editable" data-user_id='.$employer_id.' data-table_option="hrm_leave" data-id='.$value->id.'>'.$leave_cat[$value->leave_type_id].'<a>',
        '<a href="#">'. $user_info[$value->emp_id] . '</a>',
        hrm_get_date2mysql( $value->start_time ),
        hrm_get_date2mysql( $value->end_time ),
        Hrm_Leave::getInstance()->leave_status( $value->leave_status ),
        $value->leave_comments,
        Hrm_Leave::getInstance()->total_leave( $value->start_time, $value->end_time, $work_in_week, $holiday_index ),
        Hrm_Leave::getInstance()->leave_take( $value->start_time, $value->end_time, $work_in_week, $holiday_index ),
        Hrm_Leave::getInstance()->leave_remain( $value->start_time, $value->end_time, $work_in_week, $holiday_index ),
    );

    $td_attr[] = array(
        'class="check-column"'
    );
}

$table = array();
$table['head']       = array( '<input type="checkbox">', 'Leave Type', 'Employee Name', 'Start Date', 'End Date', 'Leave Status', 'Comments', 'Total Leave(day)', 'Leave Take(day)', 'Leave Remain(day)' );
$table['body']       = isset( $body ) ? $body : array();
$table['td_attr']    = isset( $td_attr ) ? $td_attr : array();
$table['th_attr']    = array( 'class="check-column"' );
$table['table_attr'] = array( 'class' => 'widefat' );
$table['table']      = 'hrm_leave';
$table['action']     = 'hrm_delete';
$table['tab']        = $tab;
$table['subtab']     = $subtab;

echo Hrm_Settings::getInstance()->table( $table );
//table

$leave_cat = isset( $leave_cat ) && is_array( $leave_cat ) ? $leave_cat : array();
$url = Hrm_Settings::getInstance()->get_current_page_url( $page, $tab, $subtab ) . '&employee_id='. $employer_id;
$file_path = urlencode(__FILE__);
?>
<script type="text/javascript">
jQuery(function($) {
    hrm_dataAttr = {
       add_form_generator_action : 'add_form',
       add_form_apppend_wrap : 'hrm_Leave_list',
       class_name : 'Hrm_Leave',
       redirect : '<?php echo $url; ?>',
       function_name : 'assign',
       user_id: '<?php echo $employer_id; ?>',
       user_info: '<?php echo json_encode( $user_info ); ?>',
       leave_cat: '<?php echo json_encode( $leave_cat ); ?>',
       employee_id: "<?php echo $employer_id; ?>",
       page: '<?php echo $page; ?>',
       tab: '<?php echo $tab; ?>',
       subtab: '<?php echo $subtab; ?>',
       req_frm: '<?php echo $file_path; ?>',
       search_satus: '<?php echo $search_satus; ?>',
       subtab: true
    };
});
</script>