class owt::install inherits owt {
    $activemqDir = "/usr/share/activemq"
    $activemqVersion = "5.13.3"

    exec { 'install_node5x':
        command => 'curl -sL https://deb.nodesource.com/setup_5.x | sudo -E bash -',
        user    => root,
        path    => '/usr/bin',
        require => File['create_node_modules_dir']
    }

    package { 'nodejs':
        ensure  => latest,
        require => Exec['install_node5x'],
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

    package{ 'rabbitmq-server':
        ensure => latest,
    }

    exec { 'install_composer':
        command     => 'curl -sS https://getcomposer.org/installer | /usr/bin/php && sudo mv /tmp/composer.phar /usr/local/bin/composer',
        require     => Package['curl', 'php5.6-common', 'git'],
        environment =>'HOME=/home/vagrant',
        user        => vagrant,
        creates     =>'/usr/local/bin/composer',
        path        => '/usr/bin',
        cwd         => '/tmp'
    }

    file { 'create_node_modules_dir':
        path    => '/usr/local/lib/node_modules',
        ensure  => directory,
        owner   => vagrant,
        group   => vagrant,
    }

    file { 'owt_log_dir':
        path   => '/var/log/owt',
        ensure => directory,
        owner  => vagrant,
        group  => vagrant,
    }

    file { 'owt_cron_log':
        path    => '/var/log/owt/cron.log',
        ensure  => present,
        owner   => vagrant,
        group   => vagrant,
        require => File['owt_log_dir'],
    }

    file { 'owt_data_dir':
        path    => "${owtDir}/var/data",
        ensure  => directory,
        owner   => vagrant,
        group   => vagrant,
    }
}