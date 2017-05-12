# MicrosoftGraphBundle

## Installation


### Add MicrosoftGraphBundle to your project

The recommended way to install the bundle is through Composer.

```bash
$ composer require 'mbdax/microsoftgraphbundle:dev-master'
```



## Configuration 

In Your config.yml:
``` yml
    microsoft_graph:
        client_id: "%client_id%"
        client_secret: "%client_secret%"
        redirect_uri: "name of your redirect route"
        prefer_time_zone: Romance Standard Time
        home_page: "microsoft_graph_homepage" # if using MicrosoftGraph routing
        storage_manager: microsoft_graph.session_storage
        version: "v1.0" #version of API GRAPH
        stateless: true # if false, the state will stored in session
        scopes:  # for more details https://developer.microsoft.com/en-us/graph/docs/authorization/permission_scopes
            - openid
            - offline_access
            #- ...


```
In routing.yml if you want use my DefaultController 

``` yml
microsoft_graph:
    resource: "@MicrosoftGraphBundle/Resources/config/routing.yml"
    prefix:   /graph
```


Go to :

    [Calendar examples]
    [SharePoint examples]
****
 [Calendar example]: </docs/Calendar.md>
 [SharePoint examples]: </docs/SharePoint.md>

### TODOS
> Abstract Entities
> Documentation