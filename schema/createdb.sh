#!/bin/bash
mysql -uroot -p"$MYSQL_ROOT_PASSWORD" < createdb.sql
mysql -uroot -p"$MYSQL_ROOT_PASSWORD" bookstore < bookstore.sql
mysql -uroot -p"$MYSQL_ROOT_PASSWORD" bookstore < sample_data.sql