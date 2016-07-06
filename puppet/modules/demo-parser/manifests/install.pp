class demo-parser::install inherits demo-parser {
    package { 'golang':
        ensure => latest,
    }

    file { 'demoparser_dir':
        path   => "$parserDir",
        ensure => directory,
        owner  => vagrant,
        group  => vagrant,
    }

    exec { 'clone_demoparser':
        command => "git clone https://github.com/stegmannc/csgo-demoparser ${$parserDir}",
        creates => "${parserDir}/.git",
        path    => '/usr/bin',
        user    => vagrant,
        require => [
            Package['git'],
            File['demoparser_dir'],
        ],
    }

    exec { 'build_demoparser':
        command     => 'go install',
        creates     => "${praserDir}/csgo-demoparser",
        path        => '/usr/bin',
        environment => [
            'GOPATH=/usr/share/go',
        ],
        cwd         => $parserDir,
        user        => vagrant,
        require     => Exec['clone_demoparser'],
    }
}