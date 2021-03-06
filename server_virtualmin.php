<?php

/**
 *
 * @author Justas Jutaz Brazauskas <jutaz@jutaz.lt>
 */
class virtualmin_remote_api {

    private $_username;
    private $_password;
    private $_host;
    private $_port;
    private $_protocol;
    private $_cache;

    public function __construct($host, $username, $password, $port = "10000", $protocol = "https://") {
        $this->_host = $host;
        $this->_port = $port;
        $this->_protocol = $protocol;
        $this->_username = $username;
        $this->_password = $password;
        $this->_cache = new stdClass();
    }

    public function get_domains($user = false) {
        if ($user === false) {
            $params = array(
                'program' => 'list-domains',
                'json' => 1,
                'multiline',
            );
            $response = $this->_decodeResponse($this->_callServer($params));
            $this->_cacheDomain($response->data);
            return $response->data;
        } else {

        }
        return false;
    }

    public function add_domain(array $params = array()) {
        $required = array(
            'domain',
            'pass',
        );
        if (!$this->_checkIfAllParamsGood($params, $required)) {
            return false;
        }
        $params['program'] = 'create-domain';
        $params['json'] = 1;
        $params[] = 'multiline';
        return $this->_decodeResponse($this->_callServer($params));
    }

    public function delete_domain(array $params = array()) {
        $required = array(
            'domain',
        );
        if (!$this->_checkIfAllParamsGood($params, $required)) {
            return false;
        }
        $params['program'] = 'delete-domain';
        $params['json'] = 1;
        $params[] = 'multiline';
        return $this->_decodeResponse($this->_callServer($params));
    }

    public function suspend_domain(array $params = array()) {
        $required = array(
            'domain',
        );
        if (!$this->_checkIfAllParamsGood($params, $required)) {
            return false;
        }
        $params['program'] = 'disable-domain';
        $params['json'] = 1;
        $params[] = 'multiline';
        return $this->_decodeResponse($this->_callServer($params));
    }

    public function unsuspend_domain(array $params = array()) {
        $required = array(
            'domain',
        );
        if (!$this->_checkIfAllParamsGood($params, $required)) {
            return false;
        }
        $params['program'] = 'enable-domain';
        $params['json'] = 1;
        $params[] = 'multiline';
        return $this->_decodeResponse($this->_callServer($params));
    }

    public function modify_domain(array $params = array()) {
        $required = array(
            'domain',
        );
        if (!$this->_checkIfAllParamsGood($params, $required)) {
            return false;
        }
        $params['program'] = 'modify-domain';
        $params['json'] = 1;
        $params[] = 'multiline';
        return $this->_decodeResponse($this->_callServer($params));
    }

    public function clone_domain(array $params = array()) {
    	$required = array(
    			'domain',
    			'newdomain',
    	);
    	if (!$this->_checkIfAllParamsGood($params, $required)) {
    		return false;
    	}
    	$params['program'] = 'clone-domain';
    	$params['json'] = 1;
    	$params[] = 'multiline';
    	return $this->_decodeResponse($this->_callServer($params));
    }

    public function create_database(array $params = array()) {
        $required = array(
            'domain',
            'name',
            'type' => 'mysql|postgres',
        );
        if (!$this->_checkIfAllParamsGood($params, $required)) {
            return false;
        }
        $params['program'] = 'create-database';
        $params['json'] = 1;
        $params[] = 'multiline';
        return $this->_decodeResponse($this->_callServer($params));
    }

    public function delete_database(array $params = array()) {
        $required = array(
            'domain',
            'name',
            'type' => 'mysql|postgres',
        );
        if (!$this->_checkIfAllParamsGood($params, $required)) {
            return false;
        }
        $params['program'] = 'delete-database';
        $params['json'] = 1;
        $params[] = 'multiline';
        return $this->_decodeResponse($this->_callServer($params));
    }

    public function list_databases(array $params = array()) {
        $required = array(
            'domain',
        );
        if (!$this->_checkIfAllParamsGood($params, $required)) {
            return false;
        }
        $params['program'] = 'list-databases';
        $params['json'] = 1;
        $params[] = 'multiline';
        return $this->_decodeResponse($this->_callServer($params));
    }

    public function disconnect_database(array $params = array()) {
        $required = array(
            'domain',
            'name',
            'type' => 'mysql|postgres',
        );
        if (!$this->_checkIfAllParamsGood($params, $required)) {
            return false;
        }
        $params['program'] = 'disconnect-database';
        $params['json'] = 1;
        $params[] = 'multiline';
        return $this->_decodeResponse($this->_callServer($params));
    }

    public function modify_database_hosts(array $params = array()) {
        $required = array(
            'domain|all-domain',
            'type' => 'mysql|postgres',
        );
        if (!$this->_checkIfAllParamsGood($params, $required)) {
            return false;
        }
        $params['program'] = 'modify-database-hosts';
        $params['json'] = 1;
        $params[] = 'multiline';
        return $this->_decodeResponse($this->_callServer($params));
    }

    public function import_database(array $params = array()) {
        $required = array(
            'domain',
            'name',
            'type' => 'mysql|postgres',
        );
        if (!$this->_checkIfAllParamsGood($params, $required)) {
            return false;
        }
        $params['program'] = 'import-database';
        $params['json'] = 1;
        $params[] = 'multiline';
        return $this->_decodeResponse($this->_callServer($params));
    }

    public function create_reseller(array $params = array()) {
        $required = array(
            'name',
            'pass',
        );
        if (!$this->_checkIfAllParamsGood($params, $required)) {
            return false;
        }
        $params['program'] = 'create-reseller';
        $params['json'] = 1;
        $params[] = 'multiline';
        return $this->_decodeResponse($this->_callServer($params));
    }

    public function delete_reseller(array $params = array()) {
        $required = array(
            'name',
        );
        if (!$this->_checkIfAllParamsGood($params, $required)) {
            return false;
        }
        $params['program'] = 'delete-reseller';
        $params['json'] = 1;
        $params[] = 'multiline';
        return $this->_decodeResponse($this->_callServer($params));
    }

    public function list_resellers(array $params = array()) {
        $params['program'] = 'list-resellers';
        $params['json'] = 1;
        $params[] = 'multiline';
        return $this->_decodeResponse($this->_callServer($params));
    }

    public function modify_reseller(array $params = array()) {
        $required = array(
            'name',
        );
        if (!$this->_checkIfAllParamsGood($params, $required)) {
            return false;
        }
        $params['program'] = 'modify-reseller';
        $params['json'] = 1;
        $params[] = 'multiline';
        return $this->_decodeResponse($this->_callServer($params));
    }

    public function create_user(array $params = array()) {
        $required = array(
            'domain',
            'user',
            'pass',
        );
        if (!$this->_checkIfAllParamsGood($params, $required)) {
            return false;
        }
        $params['program'] = 'create-user';
        $params['json'] = 1;
        $params[] = 'multiline';
        return $this->_decodeResponse($this->_callServer($params));
    }

    public function delete_user(array $params = array()) {
        $required = array(
            'domain',
            'user',
        );
        if (!$this->_checkIfAllParamsGood($params, $required)) {
            return false;
        }
        $params['program'] = 'delete-user';
        $params['json'] = 1;
        $params[] = 'multiline';
        return $this->_decodeResponse($this->_callServer($params));
    }

    public function modify_user(array $params = array()) {
        $required = array(
            'domain',
            'user',
        );
        if (!$this->_checkIfAllParamsGood($params, $required)) {
            return false;
        }
        $params['program'] = 'modify-user';
        $params['json'] = 1;
        $params[] = 'multiline';
        return $this->_decodeResponse($this->_callServer($params));
    }

    public function list_mailbox(array $params = array()) {
        $required = array(
            'domain',
            'user',
        );
        if (!$this->_checkIfAllParamsGood($params, $required)) {
            return false;
        }
        $params['program'] = 'list-mailbox';
        $params['json'] = 1;
        $params[] = 'multiline';
        return $this->_decodeResponse($this->_callServer($params));
    }

    public function list_users(array $params = array()) {
        $required = array(
            'domain',
        );
        if (!$this->_checkIfAllParamsGood($params, $required)) {
            return false;
        }
        $params['program'] = 'list-users';
        $params['json'] = 1;
        $params[] = 'multiline';
        return $this->_decodeResponse($this->_callServer($params));
    }

    public function modify_database_user(array $params = array()) {
        $required = array(
            'domain',
            'type' => 'mysql|postgres',
            'user',
        );
        if (!$this->_checkIfAllParamsGood($params, $required)) {
            return false;
        }
        $params['program'] = 'modify-database-user';
        $params['json'] = 1;
        $params[] = 'multiline';
        return $this->_decodeResponse($this->_callServer($params));
    }

    public function modify_resources(array $params = array()) {
        $required = array(
            'domain|all-domains',
        );
        if (!$this->_checkIfAllParamsGood($params, $required)) {
            return false;
        }
        $params['program'] = 'modify-resources';
        $params['json'] = 1;
        $params[] = 'multiline';
        return $this->_decodeResponse($this->_callServer($params));
    }

    public function modify_limits(array $params = array()) {
        $required = array(
            'domain|user',
        );
        if (!$this->_checkIfAllParamsGood($params, $required)) {
            return false;
        }
        $params['program'] = 'modify-limits';
        $params['json'] = 1;
        $params[] = 'multiline';
        return $this->_decodeResponse($this->_callServer($params));
    }

    public function enable_limit(array $params = array()) {
        $required = array(
            'domain|all-domains',
        );
        if (!$this->_checkIfAllParamsGood($params, $required)) {
            return false;
        }
        $params['program'] = 'enable-limit';
        $params['json'] = 1;
        $params[] = 'multiline';
        return $this->_decodeResponse($this->_callServer($params));
    }

    public function disable_limit(array $params = array()) {
        $required = array(
            'domain|all-domains',
        );
        if (!$this->_checkIfAllParamsGood($params, $required)) {
            return false;
        }
        $params['program'] = 'disable-limit';
        $params['json'] = 1;
        $params[] = 'multiline';
        return $this->_decodeResponse($this->_callServer($params));
    }

    public function restore_domain(array $params = array()) {
        $required = array(
            'source',
        );
        if (!$this->_checkIfAllParamsGood($params, $required)) {
            return false;
        }
        $params['program'] = 'restore-domain';
        $params['json'] = 1;
        $params[] = 'multiline';
        return $this->_decodeResponse($this->_callServer($params));
    }

    public function list_scheduled_backups(array $params = array()) {
        $required = array(
            'domain|user|reseller',
        );
        if (!$this->_checkIfAllParamsGood($params, $required)) {
            return false;
        }
        $params['program'] = 'list-scheduled-backups';
        $params['json'] = 1;
        $params[] = 'multiline';
        return $this->_decodeResponse($this->_callServer($params));
    }

    public function backup_domain(array $params = array()) {
        $required = array(
            'dest',
        );
        if (!$this->_checkIfAllParamsGood($params, $required)) {
            return false;
        }
        $params['program'] = 'backup-domain';
        $params['json'] = 1;
        $params[] = 'multiline';
        return $this->_decodeResponse($this->_callServer($params));
    }

    public function create_admin(array $params = array()) {
        $required = array(
            'domain',
            'name',
            'pass',
        );
        if (!$this->_checkIfAllParamsGood($params, $required)) {
            return false;
        }
        $params['program'] = 'create-admin';
        $params['json'] = 1;
        $params[] = 'multiline';
        return $this->_decodeResponse($this->_callServer($params));
    }

    public function delete_admin(array $params = array()) {
        $required = array(
            'domain',
            'name',
        );
        if (!$this->_checkIfAllParamsGood($params, $required)) {
            return false;
        }
        $params['program'] = 'delete-admin';
        $params['json'] = 1;
        $params[] = 'multiline';
        return $this->_decodeResponse($this->_callServer($params));
    }

    public function list_admins(array $params = array()) {
        $required = array(
            'domain',
        );
        if (!$this->_checkIfAllParamsGood($params, $required)) {
            return false;
        }
        $params['program'] = 'list-admins';
        $params['json'] = 1;
        $params[] = 'multiline';
        return $this->_decodeResponse($this->_callServer($params));
    }

    public function modify_admin(array $params = array()) {
        $required = array(
            'domain',
            'name',
        );
        if (!$this->_checkIfAllParamsGood($params, $required)) {
            return false;
        }
        $params['program'] = 'modify-admin';
        $params['json'] = 1;
        $params[] = 'multiline';
        return $this->_decodeResponse($this->_callServer($params));
    }

    public function list_scripts(array $params = array()) {
        $required = array(
            'all-domains|domain|user',
        );
        if (!$this->_checkIfAllParamsGood($params, $required)) {
            return false;
        }
        $params['program'] = 'list-scripts';
        $params['json'] = 1;
        $params[] = 'multiline';
        return $this->_decodeResponse($this->_callServer($params));
    }

    public function list_available_scripts(array $params = array()) {
        $params['program'] = 'list-available-scripts';
        $params['json'] = 1;
        $params[] = 'multiline';
        return $this->_decodeResponse($this->_callServer($params));
    }

    public function install_script(array $params = array()) {
        $required = array(
            'domain',
            'type',
            'version',
        );
        if (!$this->_checkIfAllParamsGood($params, $required)) {
            return false;
        }
        $params['program'] = 'install-script';
        $params['json'] = 1;
        $params[] = 'multiline';
        return $this->_decodeResponse($this->_callServer($params));
    }

    public function delete_script(array $params = array()) {
        $required = array(
            'domain',
        );
        if (!$this->_checkIfAllParamsGood($params, $required)) {
            return false;
        }
        $params['program'] = 'delete-script';
        $params['json'] = 1;
        $params[] = 'multiline';
        return $this->_decodeResponse($this->_callServer($params));
    }

    public function create_svn_repository(array $params = array()) {
        $required = array(
            'domain',
            'name',
        );
        if (!$this->_checkIfAllParamsGood($params, $required)) {
            return false;
        }
        $params['program'] = 'create-svn-repository';
        $params['json'] = 1;
        $params[] = 'multiline';
        return $this->_decodeResponse($this->_callServer($params));
    }

    public function delete_svn_repository(array $params = array()) {
        $required = array(
            'domain',
            'name',
        );
        if (!$this->_checkIfAllParamsGood($params, $required)) {
            return false;
        }
        $params['program'] = 'delete-svn-repository';
        $params['json'] = 1;
        $params[] = 'multiline';
        return $this->_decodeResponse($this->_callServer($params));
    }

    public function list_svn_repositories(array $params = array()) {
        $params['program'] = 'list-svn-repositories';
        $params['json'] = 1;
        $params[] = 'multiline';
        return $this->_decodeResponse($this->_callServer($params));
    }

    public function modify_plan(array $params = array()) {
        $required = array(
            'name|id',
        );
        if (!$this->_checkIfAllParamsGood($params, $required)) {
            return false;
        }
        $params['program'] = 'delete-svn-repository';
        $params['json'] = 1;
        $params[] = 'multiline';
        return $this->_decodeResponse($this->_callServer($params));
    }

    public function list_plans(array $params = array()) {
        $params['program'] = 'list-plans';
        $params['json'] = 1;
        $params[] = 'multiline';
        return $this->_decodeResponse($this->_callServer($params));
    }

    public function delete_plan(array $params = array()) {
        $required = array(
            'name|id',
        );
        if (!$this->_checkIfAllParamsGood($params, $required)) {
            return false;
        }
        $params['program'] = 'delete-plan';
        $params['json'] = 1;
        $params[] = 'multiline';
        return $this->_decodeResponse($this->_callServer($params));
    }

    public function create_plan(array $params = array()) {
        $required = array(
            'name',
        );
        if (!$this->_checkIfAllParamsGood($params, $required)) {
            return false;
        }
        $params['program'] = 'create-plan';
        $params['json'] = 1;
        $params[] = 'multiline';
        return $this->_decodeResponse($this->_callServer($params));
    }

    public function modify_template(array $params = array()) {
        $required = array(
            'name|id',
        );
        if (!$this->_checkIfAllParamsGood($params, $required)) {
            return false;
        }
        $params['program'] = 'modify-template';
        $params['json'] = 1;
        $params[] = 'multiline';
        return $this->_decodeResponse($this->_callServer($params));
    }

    public function list_templates(array $params = array()) {
        $params['program'] = 'list-templates';
        $params['json'] = 1;
        $params[] = 'multiline';
        return $this->_decodeResponse($this->_callServer($params));
    }

    public function get_template(array $params = array()) {
        $required = array(
            'name|id',
        );
        if (!$this->_checkIfAllParamsGood($params, $required)) {
            return false;
        }
        $params['program'] = 'get-template';
        $params['json'] = 1;
        $params[] = 'multiline';
        return $this->_decodeResponse($this->_callServer($params));
    }

    public function delete_template(array $params = array()) {
        $required = array(
            'name|id',
        );
        if (!$this->_checkIfAllParamsGood($params, $required)) {
            return false;
        }
        $params['program'] = 'delete-template';
        $params['json'] = 1;
        $params[] = 'multiline';
        return $this->_decodeResponse($this->_callServer($params));
    }

    public function create_template(array $params = array()) {
        $required = array(
            'name',
            'empty|clone'
        );
        if (!$this->_checkIfAllParamsGood($params, $required)) {
            return false;
        }
        $params['program'] = 'create-template';
        $params['json'] = 1;
        $params[] = 'multiline';
        return $this->_decodeResponse($this->_callServer($params));
    }

    public function list_certs(array $params = array()) {
        $required = array(
            'all-domains|domain|user',
        );
        if (!$this->_checkIfAllParamsGood($params, $required)) {
            return false;
        }
        $params['program'] = 'list-certs';
        $params['json'] = 1;
        $params[] = 'multiline';
        return $this->_decodeResponse($this->_callServer($params));
    }

    public function install_cert(array $params = array()) {
        $required = array(
            'domain',
        );
        if (!$this->_checkIfAllParamsGood($params, $required)) {
            return false;
        }
        $params['program'] = 'install-cert';
        $params['json'] = 1;
        $params[] = 'multiline';
        return $this->_decodeResponse($this->_callServer($params));
    }

    public function generate_cert(array $params = array()) {
        $required = array(
            'domain',
            'self|csr',
        );
        if (!$this->_checkIfAllParamsGood($params, $required)) {
            return false;
        }
        $params['program'] = 'generate-cert';
        $params['json'] = 1;
        $params[] = 'multiline';
        return $this->_decodeResponse($this->_callServer($params));
    }

    public function list_proxies(array $params = array()) {
        $required = array(
            'domain',
        );
        if (!$this->_checkIfAllParamsGood($params, $required)) {
            return false;
        }
        $params['program'] = 'list-proxies';
        $params['json'] = 1;
        $params[] = 'multiline';
        return $this->_decodeResponse($this->_callServer($params));
    }

    public function delete_proxy(array $params = array()) {
        $required = array(
            'domain',
            'path',
        );
        if (!$this->_checkIfAllParamsGood($params, $required)) {
            return false;
        }
        $params['program'] = 'delete-proxy';
        $params['json'] = 1;
        $params[] = 'multiline';
        return $this->_decodeResponse($this->_callServer($params));
    }

    public function create_proxy(array $params = array()) {
        $required = array(
            'domain',
            'path',
            'url|no-proxy',
        );
        if (!$this->_checkIfAllParamsGood($params, $required)) {
            return false;
        }
        $params['program'] = 'crate-proxy';
        $params['json'] = 1;
        $params[] = 'multiline';
        return $this->_decodeResponse($this->_callServer($params));
    }

    public function change_license(array $params = array()) {
        $required = array(
            'serial',
            'key',
        );
        if (!$this->_checkIfAllParamsGood($params, $required)) {
            return false;
        }
        $params['program'] = 'change-license';
        $params['json'] = 1;
        $params[] = 'multiline';
        return $this->_decodeResponse($this->_callServer($params));
    }

    /*
     * this method is currently unclear, because it`s documentation is unclear.
     * @TODO    clearify it`s documentation
     */

    public function change_password(array $params = array()) {
        $required = array(
            'username',
        );
        if (!$this->_checkIfAllParamsGood($params, $required)) {
            return false;
        }
        $params['program'] = 'change-password';
        $params['json'] = 1;
        $params[] = 'multiline';
        return $this->_decodeResponse($this->_callServer($params));
    }

    public function check_config(array $params = array()) {
        $params['program'] = 'check-config';
        $params['json'] = 1;
        $params[] = 'multiline';
        return $this->_decodeResponse($this->_callServer($params));
    }

    public function check_connectivity(array $params = array()) {
        $required = array(
            'domain|user',
        );
        if (!$this->_checkIfAllParamsGood($params, $required)) {
            return false;
        }
        $params['program'] = 'crate-proxy';
        $params['json'] = 1;
        $params[] = 'multiline';
        return $this->_decodeResponse($this->_callServer($params));
    }

    public function copy_mailbox(array $params = array()) {
        $required = array(
            'source',
            'dest',
        );
        if (!$this->_checkIfAllParamsGood($params, $required)) {
            return false;
        }
        $params['program'] = 'copy-mailbox';
        $params['json'] = 1;
        $params[] = 'multiline';
        return $this->_decodeResponse($this->_callServer($params));
    }

    public function create_redirect(array $params = array()) {
        $required = array(
            'domain',
            'path',
            'alias|redirect'
        );
        if (!$this->_checkIfAllParamsGood($params, $required)) {
            return false;
        }
        $params['program'] = 'create-redirect';
        $params['json'] = 1;
        $params[] = 'multiline';
        return $this->_decodeResponse($this->_callServer($params));
    }

    public function delete_redirect(array $params = array()) {
        $required = array(
            'domain',
            'path',
        );
        if (!$this->_checkIfAllParamsGood($params, $required)) {
            return false;
        }
        $params['program'] = 'delete-redirect';
        $params['json'] = 1;
        $params[] = 'multiline';
        return $this->_decodeResponse($this->_callServer($params));
    }

    public function create_shared_address(array $params = array()) {
        $required = array(
            'ip|allocate-ip',
        );
        if (!$this->_checkIfAllParamsGood($params, $required)) {
            return false;
        }
        $params['program'] = 'create-shared-address';
        $params['json'] = 1;
        $params[] = 'multiline';
        return $this->_decodeResponse($this->_callServer($params));
    }

    public function delete_shared_address(array $params = array()) {
        $required = array(
            'ip',
        );
        if (!$this->_checkIfAllParamsGood($params, $required)) {
            return false;
        }
        $params['program'] = 'delete-shared-address';
        $params['json'] = 1;
        $params[] = 'multiline';
        return $this->_decodeResponse($this->_callServer($params));
    }

    public function disable_writelogs(array $params = array()) {
        $required = array(
            'domain|all-domains',
        );
        if (!$this->_checkIfAllParamsGood($params, $required)) {
            return false;
        }
        $params['program'] = 'disable-writelogs';
        $params['json'] = 1;
        $params[] = 'multiline';
        return $this->_decodeResponse($this->_callServer($params));
    }

    public function enable_writelogs(array $params = array()) {
        $required = array(
            'domain|all-domains',
        );
        if (!$this->_checkIfAllParamsGood($params, $required)) {
            return false;
        }
        $params['program'] = 'enable-writelogs';
        $params['json'] = 1;
        $params[] = 'multiline';
        return $this->_decodeResponse($this->_callServer($params));
    }

    public function get_command(array $params = array()) {
        $required = array(
            'command',
        );
        if (!$this->_checkIfAllParamsGood($params, $required)) {
            return false;
        }
        $params['program'] = 'get-command';
        $params['json'] = 1;
        $params[] = 'multiline';
        return $this->_decodeResponse($this->_callServer($params));
    }

    public function get_dns(array $params = array()) {
        $required = array(
            'domain',
        );
        if (!$this->_checkIfAllParamsGood($params, $required)) {
            return false;
        }
        $params['program'] = 'get-dns';
        $params['json'] = 1;
        $params[] = 'multiline';
        return $this->_decodeResponse($this->_callServer($params));
    }

    public function get_ssl(array $params = array()) {
        $required = array(
            'domain',
        );
        if (!$this->_checkIfAllParamsGood($params, $required)) {
            return false;
        }
        $params['program'] = 'get-ssl';
        $params['json'] = 1;
        $params[] = 'multiline';
        return $this->_decodeResponse($this->_callServer($params));
    }

    public function info(array $params = array()) {
        $params['program'] = 'info';
        $params['json'] = 1;
        $params[] = 'multiline';
        return $this->_decodeResponse($this->_callServer($params));
    }

    public function list_bandwidth(array $params = array()) {
        $required = array(
            'domain|all-domains',
        );
        if (!$this->_checkIfAllParamsGood($params, $required)) {
            return false;
        }
        $params['program'] = 'list-bandwidth';
        $params['json'] = 1;
        $params[] = 'multiline';
        return $this->_decodeResponse($this->_callServer($params));
    }

    public function get_commands(array $params = array()) {
        $params['program'] = 'list-commands';
        $params['json'] = 1;
        $params[] = 'multiline';
        return $this->_decodeResponse($this->_callServer($params));
    }

    public function list_features(array $params = array()) {
        $params['program'] = 'get-ssl';
        $params['json'] = 1;
        $params[] = 'multiline';
        return $this->_decodeResponse($this->_callServer($params));
    }

    public function list_php_ini(array $params = array()) {
        $required = array(
            'domain|all-domains|user',
        );
        if (!$this->_checkIfAllParamsGood($params, $required)) {
            return false;
        }
        $params['program'] = 'list-php-ini';
        $params['json'] = 1;
        $params[] = 'multiline';
        return $this->_decodeResponse($this->_callServer($params));
    }

    public function list_redirects(array $params = array()) {
        $required = array(
            'domain',
        );
        if (!$this->_checkIfAllParamsGood($params, $required)) {
            return false;
        }
        $params['program'] = 'list-redirects';
        $params['json'] = 1;
        $params[] = 'multiline';
        return $this->_decodeResponse($this->_callServer($params));
    }

    public function list_shared_addresses(array $params = array()) {
        $params['program'] = 'list-shared-addresses';
        $params['json'] = 1;
        $params[] = 'multiline';
        return $this->_decodeResponse($this->_callServer($params));
    }

    public function list_styles(array $params = array()) {
        $params['program'] = 'list-styles';
        $params['json'] = 1;
        $params[] = 'multiline';
        return $this->_decodeResponse($this->_callServer($params));
    }

    public function modify_database_pass(array $params = array()) {
        $required = array(
            'domain',
            'type',
            'user',
        );
        if (!$this->_checkIfAllParamsGood($params, $required)) {
            return false;
        }
        $params['program'] = 'modify-database-pass';
        $params['json'] = 1;
        $params[] = 'multiline';
        return $this->_decodeResponse($this->_callServer($params));
    }

    public function modify_php_ini(array $params = array()) {
        $required = array(
            'domain|all-domains|user',
        );
        if (!$this->_checkIfAllParamsGood($params, $required)) {
            return false;
        }
        $params['program'] = 'modify-php-ini';
        $params['json'] = 1;
        $params[] = 'multiline';
        return $this->_decodeResponse($this->_callServer($params));
    }

    public function search_maillogs(array $params = array()) {
        $params['program'] = 'search-maillogs';
        $params['json'] = 1;
        $params[] = 'multiline';
        return $this->_decodeResponse($this->_callServer($params));
    }

    public function set_spam(array $params = array()) {
        $params['program'] = 'set-spam';
        $params['json'] = 1;
        $params[] = 'multiline';
        return $this->_decodeResponse($this->_callServer($params));
    }

    public function test_imap(array $params = array()) {
        $required = array(
            'user',
            'pass',
            'server',
            'port',
        );
        if (!$this->_checkIfAllParamsGood($params, $required)) {
            return false;
        }
        $params['program'] = 'test-imap';
        $params['json'] = 1;
        $params[] = 'multiline';
        return $this->_decodeResponse($this->_callServer($params));
    }

    public function test_pop3(array $params = array()) {
        $required = array(
            'user',
            'pass',
            'server',
            'port',
        );
        if (!$this->_checkIfAllParamsGood($params, $required)) {
            return false;
        }
        $params['program'] = 'test-pop3F';
        $params['json'] = 1;
        $params[] = 'multiline';
        return $this->_decodeResponse($this->_callServer($params));
    }

    public function test_smtp(array $params = array()) {
        $required = array(
            'to',
        );
        if (!$this->_checkIfAllParamsGood($params, $required)) {
            return false;
        }
        $params['program'] = 'test-smtp';
        $params['json'] = 1;
        $params[] = 'multiline';
        return $this->_decodeResponse($this->_callServer($params));
    }

    private function _buildQueryString(array $query = array(), $questionMark = false) {
        if (empty($query)) {
            return "";
        }
        if (!is_array($query)) {
            return "";
        }
        if ($questionMark) {
            $queryString = "?";
        } else {
            $queryString = "";
        }
        foreach ($query as $key => $value) {
            if ($queryString !== "?" && $queryString !== "") {
                $queryString .= "&";
            }
            if (is_numeric($key)) {
                $queryString .= $value . "=";
            } else {
                $queryString .= $key . "=" . $value;
            }
        }
        return $queryString;
    }

    private function _callServer(array $params = array()) {
        $queryString = $this->_buildQueryString($params);
        unset($params);
        $params = array(
            'user' => $this->_username,
            'password' => $this->_password,
        );
        $url = $this->_protocol . $this->_host . ":" . $this->_port . "/virtual-server/remote.cgi?" . $queryString;
        return $this->_get($url, true, $params);
    }

    private function _get($url = false, $return = true, array $params = array()) {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, $return);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        if (isset($params['user']) && isset($params['password'])) {
            curl_setopt($ch, CURLOPT_USERPWD, $params['user'] . ":" . $params['password']);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
        }

        $data = curl_exec($ch);
        if ($return) {
            return $data;
        }
        return true;
    }

    private function _decodeResponse($response = false, $format = "json") {
        if ($format == "json") {
            return json_decode($response);
        } elseif ($format == "xml") {

        }
        return false;
    }

    private function _cacheDomain($domains = false) {
        foreach ($domains as $domain) {
            $domainName = $domain->name;
            $this->_cache->$domainName = $domain->values;
        }
        return true;
    }

    private function _getCached($domains = false) {
        if (is_array($domains)) {
            foreach ($domains as $key => $val) {
                if ($this->_isCached($val)) {
                    $toReturn[$val] = $this->_cache->$val;
                }
            }
            return $toReturn;
        } elseif ($domains == "all") {
            return $this->_cache;
        } elseif (is_string($domains)) {
            if ($this->_isCached($domains)) {
                return $this->_cache->$domains;
            }
        }
        return false;
    }

    private function _isCached($domain = false) {
        if (property_exists($this->_cache, $domain)) {
            return true;
        }
        return false;
    }

    private function _generatePassword() {
        return substr(md5(time() . microtime(true) . mt_rand()), -8);
    }

    private function _checkIfAllParamsGood($params, $required) {
        $i = 0;
        foreach ($required as $key => $val) {
            if (is_numeric($key) && !is_string($key) && !is_array(explode("|", $key))) {
                if (array_key_exists($val, $params)) {
                    $i++;
                } else {
                    foreach ($params as $name => $param) {
                        if (is_numeric($name)) {
                            $newParams[$name] = $param;
                        }
                    }
                    foreach (array_values($newParams) as $blah => $value) {
                        if ($value == $val) {
                            $i++;
                        }
                    }
                }
            } else {
                if (is_array($exploded = explode("|", $val))) {
                    foreach ($exploded as $key => $val) {
                        if (array_key_exists($val, $params)) {
                            $values = explode('|', $val);
                            if ($values[0] == 0) {
                                $i++;
                            } else {
                                foreach ($values as $key => $valu) {
                                    if ($params[$valu] == $val) {
                                        $i++;
                                    }
                                }
                            }
                        }
                    }
                }
                if (array_key_exists($key, $params)) {
                    $values = explode('|', $val);
                    foreach ($values as $key => $val) {
                        if ($params[$key] == $val) {
                            $i++;
                        }
                    }
                }
            }
        }
        if (count($required) == $i) {
            return true;
        }
        return false;
    }

}