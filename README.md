# MicrosoftGraphBundle

## Installation


### Add MicrosoftGraphBundle to your project

The recommended way to install the bundle is through Composer.

```bash
$ composer require 'mbdax/microsoftgraphbundle:dev-master'
```



## Configuration 

You have to configure your api:
``` yml
    microsoft_graph:
        client_id: "%client_id%"
        client_secret: "%client_secret%"
        redirect_uri: "name of your redirect route"
        time_zone: "" your prefered timezone
        version: "" version of API GRAPH: 1.0 or beta,  deafault 1.0
        stateless: true # if false, the state will stored in session
        scopes:  # for more details https://developer.microsoft.com/en-us/graph/docs/authorization/permission_scopes
            - openid
            - offline_access
            - ...
            
```


### TODOS
> Token manager
> Abstract Entities
> Documentation