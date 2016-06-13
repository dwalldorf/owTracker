class demo-parser::install inherits demo-parser {
    package { 'golang':
        ensure => latest,
    }

    file { 'demo-parser-dir':
        path   => "$parserDir",
        ensure => directory,
        owner  => vagrant,
        group  => vagrant,
    }

    # exec { 'clone-demo-parser':
    #     command => 'git clone https://github.com/stegmannc/csgo-demoparser .',
    #     cwd     => $parserDir,
    #     path    => '/usr/bin',
    #     user    => vagrant,
    #     require => [File['demo-parser-dir'], Package['git']],
    #     unless  => "test -f $parserDir/.git"
    # }
}