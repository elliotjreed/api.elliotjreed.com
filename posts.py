from github import Github
from cachetools import cached, TTLCache

from settings import github_access_token

g = Github(github_access_token)
cache = TTLCache(maxsize=100, ttl=300)


@cached(cache)
def posts(category=''):
    category = category.title()
    posts_structure = {}
    repo = g.get_repo('elliotjreed/content.elliotjreed.com')
    contents = repo.get_file_contents(category)
    while len(contents) > 0:
        file_content = contents.pop(0)
        if file_content.type == 'dir':
            contents.extend(repo.get_file_contents(file_content.path))
        else:
            file_path = file_content.path.split('/')
            category = file_path[0]

            if category in posts_structure and len(category) > 0:
                posts_structure[category].append(file_path[1])
            else:
                posts_structure[category] = [file_path[1]]
    return posts_structure
