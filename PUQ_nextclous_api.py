#!/usr/bin/env python3
# -*- coding: utf-8 -*-
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
from flask import Flask, json, request
from PUQ_nextclous_class import PUQ_nextcloud

#In WHMCS is $params['customfields']['Api key'] on product
api_key = '5e84ae87e2dbdf9a517c0d08fda8cf3f'
# In WHMCS is $params['serverip']
remote_ip = '109.232.240.131'

nc = PUQ_nextcloud(api_key, remote_ip)
# Optional
# nc.sudo = '/usr/bin/sudo'
# nc.www_user = 'www-data'
# nc.php = '/usr/bin/php'
# nc.occ = '/var/www/nextcloud/occ'
# nc.nextcloud_web_dir = '/var/www/nextcloud/'

api = Flask(__name__)


@api.route('/', methods=['POST'])
def get_param():
    args = request.form.to_dict()
    return nc.api_answer(args, request.remote_addr)


if __name__ == '__main__':
    api.run(host='0.0.0.0', port=3033)
