class demo-parser::install inherits demo-parser {
    package { 'golang':
        ensure => latest,
    }

    file { 'demo_parser_dir':
        path   => "$parserDir",
        ensure => directory,
        owner  => vagrant,
        group  => vagrant,
    }

    exec { 'clone_demo_parser':
        command => "git clone https://github.com/stegmannc/csgo-demoparser ${$parserDir}",
        creates => "${parserDir}/.git",
        path    => '/usr/bin',
        user    => vagrant,
        require => [
            Package['git'],
            File['demo_parser_dir'],
        ],
    }
}