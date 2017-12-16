<div class="hrm-update-notification"></div>
<?php

if ( ! hrm_user_can_access( $page, $tab, $subtab, 'view' ) ) {

    printf( '<h1>%s</h1>', __( 'You do no have permission to access this page', 'cpm' ) );
    return;
}
?>

<?php
$header_path = dirname(__FILE__) . '/header.php';
$header_path = apply_filters( 'hrm_header_path', $header_path, 'admin' );

if ( file_exists( $header_path ) ) {
    require_once $header_path;
}

$can_edit = hrm_user_can( 'manage_hrm_organization' );

$country = hrm_Settings::getInstance()->country_list();

//default $this for class hrm_Admin, $tab, $subtab;
$field_value = Hrm_Admin::getInstance()->get_general_info();

$field['organization_name'] = array(
    'label' => __( 'Organization Name', 'hrm' ),
    'class' => 'required',
    'disabled' => $can_edit ? false : 'disabled',
    'type' => 'text',
    'value' => isset( $field_value['data']['organization_name'] ) ? $field_value['data']['organization_name'] : '',
    'extra' => array(
        'data-hrm_validation' => true,
        'data-hrm_required' => true,
        'data-hrm_required_error_msg'=> __( 'This field is required', 'hrm' ),
    ),
);
$field['tax_id'] = array(
    'label' => __( 'Tax ID', 'hrm' ),
    'disabled' => $can_edit ? false : 'disabled',
    'type' => 'text',
    'value' => isset( $field_value['data']['tax_id'] ) ? $field_value['data']['tax_id'] : ''
);
$field['registration_number'] = array(
    'label' => __( 'Registration Number', 'hrm' ),
    'disabled' => $can_edit ? false : 'disabled',
    'type' => 'text',
    'value' => isset( $field_value['data']['registration_number'] ) ? $field_value['data']['registration_number'] : ''
);


$field['phone'] = array(
    'label' => __( 'Phone', 'hrm' ),
    'disabled' => $can_edit ? false : 'disabled',
    'type' => 'text',
    'value' => isset( $field_value['data']['phone'] ) ? $field_value['data']['phone'] : ''
);
$field['fax'] = array(
    'label' => __( 'Fax', 'hrm' ),
    'disabled' => $can_edit ? false : 'disabled',
    'type' => 'text',
    'value' => isset( $field_value['data']['fax'] ) ? $field_value['data']['fax'] : ''
);
$field['email'] = array(
    'label' => __( 'email', 'hrm' ),
    'disabled' => $can_edit ? false : 'disabled',
    'type' => 'email',
    'value' => isset( $field_value['data']['email'] ) ? $field_value['data']['email'] : ''
);



$field['addres_street_1'] = array(
    'label' => __( 'Address Street 1', 'hrm' ),
    'disabled' => $can_edit ? false : 'disabled',
    'type' => 'text',
    'value' => isset( $field_value['data']['addres_street_1'] ) ? $field_value['data']['addres_street_1'] : ''
);
$field['address_street_2'] = array(
    'label' => __( 'Address Street 2', 'hrm' ),
    'disabled' => $can_edit ? false : 'disabled',
    'type' => 'text',
    'value' => isset( $field_value['data']['address_street_2'] ) ? $field_value['data']['address_street_2'] : ''
);
$field['city'] = array(
    'label' => __( 'City', 'hrm' ),
    'disabled' => $can_edit ? false : 'disabled',
    'type' => 'text',
    'value' => isset( $field_value['data']['city'] ) ? $field_value['data']['city'] : ''
);


$field['state_province'] = array(
    'label' => __( 'State/Province', 'hrm' ),
    'disabled' => $can_edit ? false : 'disabled',
    'type' => 'text',
    'value' => isset( $field_value['data']['state_province'] ) ? $field_value['data']['state_province'] : ''
);
$field['zip'] = array(
    'label' => __( 'Zip/Postal Code', 'hrm' ),
    'disabled' => $can_edit ? false : 'disabled',
    'type' => 'text',
    'value' => isset( $field_value['data']['zip'] ) ? $field_value['data']['zip'] : ''
);
$field['country'] = array(
    'label' => __( 'Country', 'hrm' ),
    'disabled' => $can_edit ? false : 'disabled',
    'type' => 'select',
    'option' => $country,
    'selected' => isset( $field_value['data']['country'] ) ? $field_value['data']['country'] : '' ,
    'desc' => 'Chose your country'
);
$field['note'] = array(
    'label' => __( 'Note', 'hrm' ),
    'disabled' => $can_edit ? false : 'disabled',
    'type' => 'textarea',
    'value' => isset( $field_value['data']['note'] ) ? $field_value['data']['note'] : ''
);

$field['header'] = 'General Information';
$field['action'] = 'single_form';
$field['table_option'] = 'hrm_general_info';
$field['tab'] = $tab;
$field['subtab'] = $subtab;
$field['page'] = $page;
$field['submit_btn'] = $can_edit;


echo Hrm_Settings::getInstance()->visible_form_generator( $field );

