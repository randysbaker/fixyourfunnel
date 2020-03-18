QUESTION:
---------
You are assigned to a major project that will attempt to abstract and consolidate similar business logic from 2
different applications. While each application serves a different market and user, each application has some
shared functionality. Currently the implementation is written separately, but some functions could be abstracted
to a single implementation. How would you determine which functionality should be abstracted and used by both
applications. Which tools (languages, cloud services, etc.) would you choose to accomplish your
implementation? 

ANSWER:
-------
Common functions that could be abstracted would be features that are redundant, such as executing an API call, performing 
generic file functions, data sanitation, authentication mechanisms, etc. I've done things like that when customizing 
WordPress instances for clients. It still allows both systems to function independently, yet it offers a leaner code base
by removing redundant functions / processes, thus creating a 'shared code' environment.