# PUQ_WHMCS-nextcloud

Module for the WHMCS system.
For manage NextCloudab servers as a product.
It is that each product is a separate intalation.

Functions

Admin area:
- Suspend the services
- Terminate the services
- Unsuspend the services
- Change the NextCloud admin password
- API connection status
- NextCloud Disk status

Client area:
- Change the NextCloud admin password
- NextCloud Disk status
--------------------------------------------------------------





```
cd /root/ 
git clone https://github.com/PUQ-sp-z-o-o/PUQ_WHMCS-nextcloud.git
cd PUQ_WHMCS-nextcloud/
```

Edit PUQ_nextclous_api.py 
```
In WHMCS is $params['customfields']['Api key'] on product
api_key = '**************************************'
In WHMCS is $params['serverip']
remote_ip = '************************************'
```
```
apt-get install python3-venv python3-pip -y
python3 -m venv env
source env/bin/activate
pip3 install flask
```

Add to crontab
```
*/1 * * * * cd /root/PUQ_WHMCS-nextcloud && env/bin/python3 PUQ_nextclous_api.py
```
