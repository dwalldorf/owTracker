# owTracker - The CS:GO Overwatch tracker

A tool to persist your CS:GO overwatch cases and see statistics of interest.

# dev setup

## Requirements
You need to have vagrant installed. If you haven't, get it: [vagrantup.com](https://www.vagrantup.com/)

## Get it running

### Setup
Check out the code base: `git checkout https://github.com/dwalldorf/owTracker.git`

Get vagrant running: (from inside the project directory)`vagrant up` and get a coffee.

Once vagrant has finished it's setup, connect to the vm and set up the project:

    vagrant ssh
    ./bin/build.sh

This will install all required composer and npm packages and prepare the frontend application. 
Point your browser to [localhost:8080](http://localhost:8080) and get going.

If you fiddle around with styling or the frontend app, use the watch script to watch for changes and compile your scss to css / typescript to JS: 

    vagrant ssh
    ./bin/watch.sh

### Commands
There are some commands to make some tasks easier. Execute them within your vm with `./bin/console {commandName}`. All custom commands are prefixed `owt:`.
If you want to see help and options for a command, call it with `-h`.

#### Create test data
The command `owt:createTestData` will create verdicts and / or users for which is handy when developing.

#### Delete test data
Will delete all test users and their data from the system.