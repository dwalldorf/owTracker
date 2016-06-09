class mongo::install inherits mongo {
    exec { 'add_mongo_org_ppa':
        command => '/usr/bin/apt-key adv --keyserver hkp://keyserver.ubuntu.com:80 --recv 7F0CEB10 && /bin/echo "deb http://repo.mongodb.org/apt/ubuntu trusty/mongodb-org/3.0 multiverse" | /usr/bin/tee /etc/apt/sources.list.d/mongodb-org-3.0.list && /usr/bin/apt-get update',
        user    => root,
        creates =>'/etc/apt/sources.list.d/mongodb-org-3.0.list',
    }

    package { 'mongodb-org':
        ensure  => latest,
        require => Exec['add_mongo_org_ppa'],
    }
    package{ 'php5-mongo':
        ensure  => latest,
        require => Package['php5'],
        notify  => Service['php5-fpm'],
    }
}