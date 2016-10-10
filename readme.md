FORMAT: 1A

# CLAIM-SERVICE

# Claim [/claims]
Claim  resource representation.

## Show all claims [GET /claims]


+ Request (application/json)
    + Body

            {
                "search": {
                    "_id": "string",
                    "owner": "string"
                },
                "sort": {
                    "newest": "asc|desc",
                    "title": "desc|asc"
                },
                "take": "integer",
                "skip": "integer"
            }

+ Response 200 (application/json)
    + Body

            {
                "status": "success",
                "data": {
                    "data": {
                        "_id": "string",
                        "title": "string",
                        "reference_id": "string",
                        "accident": {
                            "date": "string",
                            "place": "string",
                            "details": "string"
                        },
                        "issued": {
                            "at": "datetime",
                            "by": {
                                "_id": "string",
                                "name": "string"
                            },
                            "to": {
                                "_id": "string",
                                "name": "string"
                            }
                        }
                    },
                    "count": "integer"
                }
            }

## Store Claim [POST /claims]


+ Request (application/json)
    + Body

            {
                "_id": "string",
                "title": "string",
                "reference_id": "string",
                "accident": {
                    "date": "string",
                    "place": "string",
                    "details": "string"
                },
                "issued": {
                    "at": "datetime",
                    "by": {
                        "_id": "string",
                        "name": "string"
                    },
                    "to": {
                        "_id": "string",
                        "name": "string"
                    }
                }
            }

+ Response 200 (application/json)
    + Body

            {
                "status": "success",
                "data": {
                    "_id": "string",
                    "title": "string",
                    "reference_id": "string",
                    "accident": {
                        "date": "string",
                        "place": "string",
                        "details": "string"
                    },
                    "issued": {
                        "at": "datetime",
                        "by": {
                            "_id": "string",
                            "name": "string"
                        },
                        "to": {
                            "_id": "string",
                            "name": "string"
                        }
                    }
                }
            }

+ Response 200 (application/json)
    + Body

            {
                "status": {
                    "error": [
                        "code must be unique."
                    ]
                }
            }

## Delete Claim [DELETE /claims]


+ Request (application/json)
    + Body

            {
                "id": null
            }

+ Response 200 (application/json)
    + Body

            {
                "status": "success",
                "data": {
                    "_id": "string",
                    "title": "string",
                    "reference_id": "string",
                    "accident": {
                        "date": "string",
                        "place": "string",
                        "details": "string"
                    },
                    "issued": {
                        "at": "datetime",
                        "by": {
                            "_id": "string",
                            "name": "string"
                        },
                        "to": {
                            "_id": "string",
                            "name": "string"
                        }
                    }
                }
            }

+ Response 200 (application/json)
    + Body

            {
                "status": {
                    "error": [
                        "code must be unique."
                    ]
                }
            }