class owt::config inherits owt {
    file { 'node_modules_dir':
        path   => "${owtDir}/node_modules",
        ensure => directory,
    }

    file{ 'web-lib-dir':
        path   => "${owtDir}/web/lib",
        ensure => directory,
    }
    file { 'node_modules_symlink':
        path    => "${owtDir}/web/lib/node_modules",
        target  => "${owtDir}/node_modules",
        ensure  => symlink,
        require => File['web-lib-dir', 'node_modules_dir'],
    }

    cron { 'owtCrons':
        command => "${owtDir}/bin/console owt:cron >> /var/log/owt/cron.log",
        user    => vagrant,
        hour    => '*',
        minute  => '*/2',
        require => File['owt_cron_log'],
    }
}