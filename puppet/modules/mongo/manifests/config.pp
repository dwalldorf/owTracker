class mongo::config inherits mongo {

    exec { 'create_mongo_admin':
        environment=>'LC_ALL=C',
        command    => '/usr/bin/mongo --eval \'db.createUser({ user: "sa", pwd: "sa", roles: [ {role: "root", db: "admin"} ] })\' admin',
        unless     => '/usr/bin/mongo -u "sa" -p "sa" admin',
        require    => Package['mongodb-org'],
    }

    file { 'mongod.conf':
        path    => '/etc/mongod.conf',
        source  => 'puppet:///modules/mongo/mongod.conf',
        ensure  => file,
        owner   => 'root',
        group   => 'root',
        mode    => 0644,
        require => [Package['mongodb-org'], Exec['create_mongo_admin']],
        notify  => Service['mongod'],
    }

}