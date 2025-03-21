from phpserialize import phpobject

user = loads(data, object_hook=phpobject)

output = dumps(data, object_hook=phpobject)