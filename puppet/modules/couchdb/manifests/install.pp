class couchdb::install inherits couchdb {
    package{ 'couchdb':
        ensure => latest,
    }
}