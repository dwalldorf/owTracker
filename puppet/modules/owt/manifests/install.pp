class owt::install inherits owt {

    exec { 'add_node5x':
        command => 'curl -sL https://deb.nodesource.com/setup_5.x | sudo -E bash -',
        user    => root,
        path    => '/usr/bin',
        require => File['create_node_modules_dir']
    }

    package { 'nodejs':
        ensure  => latest,
        require => Exec['add_node5x'],
    }

    package{ 'ruby':
        ensure => latest,
    }

    exec { 'install_sass':
        user    => root,
        command => '/usr/bin/gem install sass',
        require => Package['ruby'],
        creates => '/usr/local/bin/sass',
    }

    package { 'memcached':
        ensure => latest,
    }

    exec { 'install_composer':
        command    => 'curl -sS https://getcomposer.org/installer | /usr/bin/php && sudo mv /tmp/composer.phar /usr/local/bin/composer',
        require    => Package['curl', 'php5', 'git'],
        environment=>'HOME=/home/vagrant',
        user       => vagrant,
        creates    =>'/usr/local/bin/composer',
        path       => '/usr/bin',
        cwd        => '/tmp'
    }

    file { 'create_node_modules_dir':
        path    => '/usr/local/lib/node_modules',
        ensure  => directory,
        owner   => vagrant,
        group   => vagrant,
    }

}