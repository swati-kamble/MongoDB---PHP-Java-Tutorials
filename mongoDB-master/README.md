# MongoDB - PHP & Java Tutorials
- [**PHP** MongoDB tutorials](https://github.com/ugrcoban/mongoDB/tree/master/php)
- [**Java** MongoDB tutorials](https://github.com/ugrcoban/mongoDB/tree/master/java)

# MongoDB - Shell Scripting
> Basic MongoDB functions and tutorials on terminal. Please install mongoDB on your server. And then,
```
C:\Program Files\MongoDB\Server\4.0\bin>mongo
```



## Create Database
> Create database or use existing database.
```
>use ugurdb
switched to db ugurdb
```

> Check your db. Your created database (ugurdb), But it is not present in list. (Because no data yet)
```
>db
ugurdb
>show dbs
local     0.000GB
config    0.000GB
admin     0.000GB
```



## Create Collections(table)
> MongoDB creates collection automatically, when you insert some document. Also you can create before.
```
>db.createCollection("logs")
{ "ok" : 1 }
>show dbs
local     0.000GB
config    0.000GB
admin     0.000GB
ugurdb    0.000GB
```

> Add row to 'users' collection. Created automatically "users" collection.
```
>db.users.insert({"name":"UGUR COBAN"})
WriteResult({ "nInserted" : 1 })
>db.users.insert([
   {
      _id: 1, 
      name: 'MongoDB is no sql database',
      tags: ['mongodb', 'database', 'NoSQL'],
      counter: 100
   },
   {
      name: "NoSQL database doesn't have tables",
      counter: 20, 
      comments: [	
         {
            user:'user1',
            message: 'My first comment',
            dateCreated: new Date(2013,11,10,2,35)
         }
      ]
   }
])
BulkWriteResult({
        "writeErrors" : [ ],
        "writeConcernErrors" : [ ],
        "nInserted" : 2,
        "nUpserted" : 0,
        "nMatched" : 0,
        "nModified" : 0,
        "nRemoved" : 0,
        "upserted" : [ ]
})
```

> Add row to 'files' collection. And Save record. 
```
>db.files.save( { file: 'selam.txt' } )
WriteResult({ "nInserted" : 1 })
>db.files.save( { file: 'selam.txt', date:"2019-02-02" } )
WriteResult({ "nInserted" : 1 })
```

> Show Collections(tables)
```
>show collections
files
logs
users
```


## Find(Select) rows from collection
> Simple select query
```
>db.users.find()
{ "_id" : ObjectId("5cbeae4fff0796a9ba06538b"), "name" : "UGUR COBAN" }
{ "_id" : 1, "name" : "MongoDB is no sql database", "tags" : [ "mongodb", "database", "NoSQL" ], "counter" : 100 }
{ "_id" : ObjectId("5cbeb287ff0796a9ba06538e"), "name" : "NoSQL database doesn't have tables", "counter" : 20, "comments" : [ { "user" : "user1", "message" : "My first comment", "dateCreated" : ISODate("2013-12-09T23:35:00Z") } ] }
```

> Conditions **$and** **$or**. Also Display format {key:1}. ( pretty() method for formatted. )
```
>db.files.find({$and:[{"file":"selam.txt"}]} , {"file":1,_id:0} ).pretty()
{ "file" : "selam.txt" }
{ "file" : "selam.txt" }
```

> The basis of some condition, you can use following operations.

| Operation | Syntax | RDBMS (Where) |
| ------ | ------ | ------ |
| Equality | **:** | name = 'UGUR COBAN'
| Less Than	 | **$lt** | counter < 50
| Less Than Equals	 | **$lte** | counter <= 50
| Greater Than	 | **$gt** | counter > 50
| Greater Than Equals	 | **$gte** | counter >= 50
| Not Equals	 | **$ne** | counter != 50

> Where condition : (name = 'UGUR COBAN' OR anyfieldname = 'anytext' OR counter>50)
```
>db.users.find({ "counter": {$gt:50}, $or: [{"name": "UGUR COBAN"}, {"anyfieldname": "anytext"}] }).pretty()
```

> Where condition : counter>50 AND (name = 'UGUR COBAN' OR anyfieldname = 'anytext')
```
>db.users.find({ $or: [{"name": "UGUR COBAN"}, {"anyfieldname": "anytext"}, {"counter": {$gt:50}} ] }).pretty()
{ "_id" : ObjectId("5cbeae4fff0796a9ba06538b"), "name" : "UGUR COBAN" }
{
        "_id" : 1,
        "name" : "MongoDB is no sql database",
        "tags" : [
                "mongodb",
                "database",
                "NoSQL"
        ],
        "counter" : 100
}
```

> Simple RDBMS: "ORDER BY name ASC LIMIT 1,2". Sorting (ASC:1,DESC-1) //  LIMIT skip,limit
```
>db.users.find().sort({name:1}).skip(1).limit(2)
{ "_id" : 1, "name" : "MongoDB is no sql database", "tags" : [ "mongodb", "database", "NoSQL" ], "counter" : 100 }
{ "_id" : ObjectId("5cbeb287ff0796a9ba06538e"), "name" : "NoSQL database doesn't have tables", "counter" : 20, "comments" : [ { "user" : "user1", "message" : "My first comment", "dateCreated" : ISODate("2013-12-09T23:35:00Z") } ] }
```

## Documents(Rows) Update / Remove(Delete) 
> Update Documents ( To update multiple documents,'multi' to true )
```
db.users.update({'name':'UGUR COBAN'},
   {$set:{'name':'COBAN UGUR'}},{multi:true})
WriteResult({ "nMatched" : 1, "nUpserted" : 0, "nModified" : 1 })
```

> Delete Documents 
```
db.file.remove({"_id": ObjectId("5cbeae8fff0796a9ba06538c")})
WriteResult({ "nRemoved" : 0 })
db.files.remove({"_id": ObjectId("5cbeae8fff0796a9ba06538c")})
WriteResult({ "nRemoved" : 1 })
```

> Delete All Documents ( Truncate table )
```
db.files.remove({})
WriteResult({ "nRemoved" : 1 })
db.files.find()
```


## Drop Collection / Database
> Drop Collection(table)
```
>show collections
files
logs
users
>db.files.drop()
true
>show collections
logs
users
```

> Drop Database  ( If you have not selected any database, then it will delete default 'test' database. )
```
>use ugurdb
switched to db ugurdb
>db.dropDatabase()
{ "dropped" : "ugurdb", "ok" : 1 }
```

## Help & Stats & Version
```
>db.help()
>db.stats();
>db.version();
```

## MangoDB Deployment
> Create Backup
```
D:\set up\mongodb\bin>mongodump
```

> Restore Backup
```
D:\set up\mongodb\bin>mongorestore
```

> To check counters of database operations
```
D:\set up\mongodb\bin>mongostat
```

> Tracks and reports activity
```
D:\set up\mongodb\bin>mongotop
```
 

## Documentation

* [MongoDB - Download](https://www.mongodb.com/download-center/community)
* [MongoDB - TutorialsPoint Overview](https://www.tutorialspoint.com/mongodb/index.htm)
