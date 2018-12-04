# Github Avatars

This small utility downloads all the collaborators' avatars as JPEG images from a given repository.

### Usage:

```bash
php github-avatars.php download <account> <repository> [-u username] [-p password] [-d directory]
```

* account: the github account (mandatory)
* repository: the repository name (mandatory)
* username, password: for authentication to private repositories (optional)
* directory: avatars will be saved to this directory (optional) 
