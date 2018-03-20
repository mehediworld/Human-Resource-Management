export default {
	methods: {
		showHideDepartmentForm (status, department) {
            var department   = department || false,
                department   = jQuery.isEmptyObject(department) ? false : department;

            if ( department ) {
                if ( status === 'toggle' ) {
                    department.edit_mode = department.edit_mode ? false : true;
                } else {
                    department.edit_mode = status;
                }
            } else {
                this.$store.commit( 'departments/showHideDepartmentForm', status);
            }
        },

        manageDepartment() {
            return hrm_user_can('manage_department');
        },

        getDepartments: function() {
            var request_data = {
                _wpnonce: HRM_Vars.nonce,
            },
            self = this;

            wp.ajax.send('get_departments', {
                data: request_data,
                success: function(res) {
                    self.$store.commit( 
                        'departments/setDepartments', 
                        { 
                            departments: res.departments
                        } 
                    );
                },

                error: function(res) {
                    
                }
            });
        },
		
	}	
}