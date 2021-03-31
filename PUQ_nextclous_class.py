"""
 +-----------------------------------------------------------------------------------------+
 | This file is part of the WHMCS module. "PUQ_WHMCS-nextcloud"                            |
 | The module allows you to manage the Nextcloud server as a product in the system WHMCS.  |
 | This program is free software: you can redistribute it and/or modify it                 |
 +-----------------------------------------------------------------------------------------+
 | Author: Ruslan Poloviy ruslan.polovyi@puq.pl                                            |
 | Warszawa 03.2021 PUQ sp. z o.o. www.puq.pl                                              |
 +-----------------------------------------------------------------------------------------+
"""
import os
import subprocess
import json
import hashlib


class PUQ_nextcloud:
    local_hash = ''
    api_key = ''
    remote_ip = ''
    sudo = '/usr/bin/sudo'
    www_user = 'www-data'
    php = '/usr/bin/php'
    occ = '/var/www/nextcloud/occ'
    nextcloud_web_dir = '/var/www/nextcloud/'

    #################################
    def __init__(self, api_key, remote_ip):
        self.local_hash = hashlib.md5(str(remote_ip + '|' + api_key).encode()).hexdigest()
        print(self.local_hash)
        self.api_key = api_key
        self.remote_ip = remote_ip

    #################################
    def occ_command(self, comm, json):
        if json is False:
            cmd = self.sudo + ' -u ' + self.www_user + ' ' + self.php + ' ' + self.occ + ' ' + comm
        else:
            cmd = self.sudo + ' -u ' + self.www_user + ' ' + self.php + ' ' + self.occ + ' ' + comm + ' --output=json'
        return cmd

    #################################
    def UsageUpdate(self):
        storage = {}
        cmd = self.occ_command('config:system:get datadirectory', True)
        data_dir = subprocess.check_output(cmd, shell=True)
        dir = json.loads(data_dir)
        st = os.statvfs(dir)
        free = st.f_bavail * st.f_frsize
        total = st.f_blocks * st.f_frsize
        used = (st.f_blocks - st.f_bfree) * st.f_frsize
        storage['total'] = str(total)
        storage['free'] = str(free)
        storage['used'] = str(used)
        return storage

    #################################
    def status(self):
        status = {}
        cmd = self.occ_command('config:system:get datadirectory', True)
        data_dir = subprocess.check_output(cmd, shell=True)
        dir = json.loads(data_dir)
        st = os.statvfs(dir)
        free = st.f_bavail * st.f_frsize
        total = st.f_blocks * st.f_frsize
        used = (st.f_blocks - st.f_bfree) * st.f_frsize
        status['disk_total'] = str(total)
        status['disk_free'] = str(free)
        status['disk_used'] = str(used)
        return status

    #################################
    def SuspendAccount(self):
        cmd = self.occ_command('maintenance:mode --on', False)
        data = subprocess.check_output(cmd, shell=True)
        return data.strip().decode('utf-8')

    #################################
    def UnsuspendAccount(self):
        cmd = self.occ_command('maintenance:mode --off', False)
        data = subprocess.check_output(cmd, shell=True)
        return data.strip().decode('utf-8')

    #################################
    def ChangePassword(self, user, password):
        cmd = 'export OC_PASS=\"' + password + '\" && su -s /bin/sh www-data -c \"/usr/bin/php /var/www/nextcloud/occ ' \
                                               'user:resetpassword --password-from-env ' + user + '\" '
        try:
            data = subprocess.check_output(cmd, shell=True)
            text = data.strip().decode('utf-8')
            return text
        except:
            return 'Password not changed.'

    #################################
    def api_answer(self, args, client_ip):
        answer = {
            'msg': '',
            'err': 1,
            'error': 'There is no suitable answer.'
        }

        if 'hash' not in args:
            answer['msg'] = ''
            answer['err'] = 1
            answer['error'] = 'Request processing problem.'
            return json.dumps(answer)

        if 'hash' in args:
            if args['hash'] == self.local_hash and self.remote_ip == client_ip:
                ###
                if args['command'] == 'SuspendAccount':
                    answer['msg'] = self.SuspendAccount()
                ###
                if args['command'] == 'UnsuspendAccount':
                    answer['msg'] = self.UnsuspendAccount()
                ###
                if args['command'] == 'UsageUpdate':
                    answer['msg'] = self.UsageUpdate()
                ###
                if args['command'] == 'status':
                    answer['msg'] = self.status()
                ###
                if args['command'] == 'ChangePassword':
                    answer['msg'] = self.ChangePassword(args['username'], args['password'])
                ###
            else:
                answer['error'] = 'Wrong API key or client IP'
                answer['err'] = 1

        ####
        if answer['msg'] != '':
            answer['err'] = 0
            answer['error'] = ''

        return json.dumps(answer)
