# PUQ_WHMCS-nextcloud

cd /root/ 

https://github.com/PUQ-sp-z-o-o/PUQ_WHMCS-nextcloud.git
cd PUQ_WHMCS-nextcloud/

Edit in PUQ_nextclous_api.py 
```
In WHMCS is $params['customfields']['Api key'] on product
api_key = '**************************************'
In WHMCS is $params['serverip']
remote_ip = '************************************'

apt-get install python3-venv python3-pip -y
python3 -m venv env
source env/bin/activate
pip3 install flask
```

Add to crontab
```
*/1 * * * * cd /root/PUQ_WHMCS-nextcloud && env/bin/python3 PUQ_nextclous_api.py
```
