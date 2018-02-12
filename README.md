[![Build Status](https://travis-ci.org/NINEJKH/bitbucket-cli.svg?branch=master)](https://travis-ci.org/NINEJKH/bitbucket-cli)

# bitbucket-cli

A bitbucket cli tool.

## Installation

```bash
$ curl -#fL "$(curl -s https://api.github.com/repos/NINEJKH/bitbucket-cli/releases/latest | grep 'browser_download_url' | sed -n 's/.*"\(http.*\)".*/\1/p')" | sudo tee /usr/local/bin/bitbucket > /dev/null && sudo chmod +x /usr/local/bin/bitbucket
```

## Auth

1. Create App password: https://bitbucket.org/account/user/YOUR_USERNAME/app-passwords
2. Add those details in `~/.bitbucket`

```
[auth]
username = <Your Username>
password = <Your Password>
```

## Usage

### Pull requests

#### Get pull request

```bash
$ bitbucket repositories:pullrequests:get NINEJKH/bitbucket-cli 4
```

#### Update pull request

```bash
$ bitbucket repositories:pullrequests:update NINEJKH/bitbucket-cli 4 < payload.json
```

### Update pull request description

```bash
$ bitbucket repositories:pullrequests:update:description NINEJKH/bitbucket-cli 4 "new description (or via STDIN)"
```

