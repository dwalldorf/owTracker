class mongo::config inherits mongo {

    exec { 'create_mongo_admin':
        environment=>'LC_ALL=C',
        command    => '/usr/bin/mongo --eval \'db.createUser({ user: "sa", pwd: "sa", roles: [ {role: "root", db: "admin"} ] })\' admin',
        unless     => '/usr/bin/mongo -u "sa" -p "sa" admin',
        require    => Package['mongodb-org'],
    }

    exec { 'create_mongo_todo_user':
        environment=>'LC_ALL=C',
        command    => '/usr/bin/mongo --eval \'db.createUser({ user: "todo_user", pwd: "pass123", roles: [ {role: "dbOwner", db: "todo"} ] })\' todo',
        unless     => '/usr/bin/mongo -u "todo_user" -p "pass123" todo',
        require    => Package['mongodb-org'],
    }

    file { 'mongod.conf':
        path    => '/etc/mongod.conf',
        source  => 'puppet:///modules/mongo/mongod.conf',
        ensure  => file,
        owner   => 'root',
        group   => 'root',
        mode    => 0644,
        require => [Package['mongodb-org'], Exec['create_mongo_admin', 'create_mongo_todo_user']],
        notify  => Service['mongod'],
    }

    file { 'nginx_phpmongo':
        path    => '/etc/nginx/sites-available/phpmongo.localhost',
        source  => 'puppet:///modules/mongo/phpmongo.localhost',
        ensure  => file,
        owner   => 'root',
        group   => 'root',
        mode    => 0644,
        notify  => Service['nginx'],
        require => [Package['nginx', 'mongodb-org'], Exec['install_phpmongo']],
    }
    file { 'nginx_phpmongo_enabled':
        path    => '/etc/nginx/sites-enabled/phpmongo.localhost',
        ensure  => link,
        target  => '/etc/nginx/sites-available/phpmongo.localhost',
        notify  => Service['nginx'],
        require => File['nginx_phpmongo'],
    }

    file { 'phpmongo_conf':
        path    => '/var/www/phpmongo/config.php',
        source  => 'puppet:///modules/mongo/phpmongo_config.php',
        ensure  => file,
        owner   => 'root',
        group   => 'root',
        mode    => 0644,
        require => Exec['install_phpmongo'],
    }

    exec { 'fix_phpmongo_setHomeUri':
        command => '/bin/sed -i \'s/self::$homeUri \.= $_SERVER\["SERVER_NAME"\];/self::$homeUri \.= $_SERVER\["SERVER_NAME"\] \. ":8080";/\' /var/www/phpmongo/system/Theme.php',
        user    => root,
        require => Exec['install_phpmongo'],
    }

}