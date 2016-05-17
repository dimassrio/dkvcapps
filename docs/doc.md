FORMAT: 1A

# laradokudocs

# Video

## [getAll get all JSON representation of all the video of doku.] [GET /video]


+ Parameters
    + limit: (integer, optional) - add limit to returned json
        + Default: 100
    + offset: (integer, optional) - add offset to returned json and skip a couple id
        + Default: 0

+ Response 200 (application/json)
    + Body

            {
                "id": 1,
                "title": "Lorem Ipsum",
                "url": "http://youtube.com/watch?v=1234567",
                "created_at": "2000-01-01 00:00:00",
                "updated_at": "2000-01-01 00:00:00"
            }

## [getEntity get entity of a video.] [GET /video/{id}]


+ Response 200 (application/json)
    + Body

            {
                "id": 1,
                "title": "Lorem Ipsum",
                "url": "http://youtube.com/watch?v=1234567",
                "created_at": "2000-01-01 00:00:00",
                "updated_at": "2000-01-01 00:00:00"
            }

## [postEntity create a new entity of video and return its representaiton] [POST /video]


+ Request (application/json)
    + Body

            {
                "title": "Lorem Ipsum",
                "url": "http://youtube.com/watch?v=1234567"
            }

+ Response 200 (application/json)
    + Body

            {
                "id": 1,
                "title": "Lorem Ipsum",
                "url": "http://youtube.com/watch?v=1234567",
                "created_at": "2000-01-01 00:00:00",
                "updated_at": "2000-01-01 00:00:00"
            }

## [putEntity change the properties of an entity] [PUT /video/{id}]


+ Request (application/json)
    + Body

            {
                "title": "Lorem Ipsum",
                "url": "http://youtube.com/watch?v=1234567"
            }

+ Response 200 (application/json)
    + Body

            {
                "id": 1,
                "title": "Lorem Ipsum",
                "url": "http://youtube.com/watch?v=1234567",
                "created_at": "2000-01-01 00:00:00",
                "updated_at": "2000-01-01 00:00:00"
            }

## [deleteEntity delete entity] [DELETE /video/{id}]


+ Response 204 (application/json)

## [toggleLike like or unlike a video] [POST /video/{id}/like]


+ Request (application/json)
    + Body

            {
                "user_id": 1
            }

+ Response 201 (application/json)

+ Response 204 (application/json)

# Comments

## [getAll get all comment in one video] [GET /video/{id}/comments]


+ Response 200 (application/json)
    + Body

            {
                "comments": "Eius dignissimos autem et odit eos adipisci. Minus non laborum eveniet quia quam.",
                "level": 0,
                "parent": 0,
                "uri": "comments/1",
                "user_id": 1,
                "flag": 3,
                "video": {
                    "data": []
                },
                "flaglist": "[1,2,3]"
            }

## [getEntity get commnet entity] [GET /comments/{id}]


+ Response 200 (application/json)
    + Body

            {
                "comments": "Eius dignissimos autem et odit eos adipisci. Minus non laborum eveniet quia quam.",
                "level": 0,
                "parent": 0,
                "uri": "comments/1",
                "user_id": 1,
                "flag": 3,
                "video": {
                    "data": []
                },
                "flaglist": "[1,2,3]"
            }

## [postEntity post comment entity] [POST /video/{id}/comments]


+ Request (application/json)
    + Body

            {
                "comments": "Eius dignissimos autem et odit eos adipisci. Minus non laborum eveniet quia quam.",
                "user_id": 1,
                "level": 0,
                "parent": 0
            }

+ Response 200 (application/json)
    + Body

            {
                "comments": "Eius dignissimos autem et odit eos adipisci. Minus non laborum eveniet quia quam.",
                "level": 0,
                "parent": 0,
                "uri": "comments/1",
                "user_id": 1,
                "flag": 3,
                "video": "{}",
                "flaglist": "[1,2,3]"
            }

## [deleteEntity delete comment entity] [DELETE /comments/{id}]


+ Response 203 (application/json)

## [toggleFlag add or remove comment flag] [POST /comments/{id}/flag]


+ Request (application/json)
    + Body

            {
                "user_id": 1
            }

+ Response 201 (application/json)