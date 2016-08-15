#!/bin/bash
#author jamlee webboy89860@gmail.com
# this file is a shortcut file to quickly ssh to apache and db containers

case $1 in
  apache)
    name=`docker-compose ps| grep web | awk '{print $1}'`
    docker exec -ti $name  /bin/bash
  ;;
  mysql)
    db_name=`docker-compose ps| grep db | awk '{print $1}'`
    docker exec -ti $db_name  /bin/bash
  ;;
 
  *)
    cat <<EOF

    """""""""""""""""""""""""""""""""""""""""""""""
    "
    " DOCKER DEV ENV  HELPER
    "
    """"""""""""""""""""""""""""""""""""""""""""""

    please input one of following keyword:

        apache, mysql

    for example:
        ./ctl apache #enter apache




EOF
  ;;

esac