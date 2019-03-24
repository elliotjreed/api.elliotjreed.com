from github import Github
from cachetools import cached, TTLCache

from settings import github_access_token

g = Github(github_access_token)
cache = TTLCache(maxsize=100, ttl=300)


@cached(cache)
def categories():
    categories_list = []
    repo = g.get_repo('elliotjreed/content.elliotjreed.com')
    contents = repo.get_file_contents('')
    while len(contents) > 0:
        file_content = contents.pop(0)
        if file_content.type == 'dir':
            categories_list.append(file_content.path)
    return categories_list
