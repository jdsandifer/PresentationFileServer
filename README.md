## Presentation File Server
In my work as a part-time software developer at the Oregon Convention Center, 
I have been contributing to the development of a file server and distibution system 
for conventions to use to facilitate easy presentation file management.

The speaker uploads their presentation files, reviews and updates them as they desire, 
and we take care of making sure they end up in the right room at the right time - no 
messing with USB drives and wasting precious presentation time loading up files.

This is especially useful for clients with flash talks (or any presentation less that 20 minutes long). 

### Background
The team developing the product is comprised of two people: the product creator and myself. 
He came up with the idea, got the basic implementation working, and then brought me on 
a while later after I expressed interest in helping with the project.

### My Contributions
Aside from writing code, I've contributed to the project in three main ways:

1) Championing **readable, maintainable, reliable code.** I've been instrumental in 
raising the level of code quality significantly.

2) Introducing best practices, especially **Object-Oriented Programming**, to the team.

3) Adding **Mac functionality**. As a developer who's familiar with multiple OS's, 
I had the most experience with Mac's and am pioneering the addition of Mac support 
to the system.

### Code
In this repository you'll see examples of some of the code I've written for the project. 
You'll notice some examples of OOP and design patterns as well as basic good coding practices: 
self-documenting code, readability, having a consistent code style, and building in room for 
changes (modularity).

Please note that I've removed a few lines of core functionality and changed some file names 
to keep some of the inner workings of the system private. I've noted these areas with obvious comments.

### Things To See
- A Strategy-like pattern in `FileTransferProtocol.php` (the interface), `FirstProtocol.php`, and `SecondProtocol.php` (I changed the names of the last two files)
- A factory method in `FileTransferProtocols.php` - note the comment to explain the "magic" of how it works to others on the team who aren't yet familiar with the pattern
- The command pattern in `FilePushToClientFromServer.php` and `FilePullFromClientToServer.php` (the objects encapsulate commands preparing the way to easily implement undo or a command queue due to their consistent interface with the `run()` method)
- Standard method and class headers to work with documentation extractors and IDE's. We don't use either of those, though, so it's primarily a habit I'm training myself to follow. (That also explains why I haven't perfectly implemented it everywhere...)
