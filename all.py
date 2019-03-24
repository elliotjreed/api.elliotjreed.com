from github import Github
from cachetools import cached, TTLCache

from settings import github_access_token

g = Github(github_access_token)
cache = TTLCache(maxsize=100, ttl=300)


@cached(cache)
def all_posts():
    posts_structure = []
    repo = g.get_repo('elliotjreed/content.elliotjreed.com')
    contents = repo.get_file_contents('')
    while len(contents) > 0:
        file_content = contents.pop(0)
        if file_content.type == 'dir':
            contents.extend(repo.get_file_contents(file_content.path))
        else:
            file_path = file_content.path

            posts_structure.append(file_path)
    return posts_structure
