from cachetools import cached, TTLCache
from github import Github

from settings import github_access_token

g = Github(github_access_token)
cache = TTLCache(maxsize=100, ttl=300)


@cached(cache)
def post(category, link):
    repo = g.get_repo('elliotjreed/content.elliotjreed.com')
    file_path = repo.get_file_contents(category + '/' + link).path
    return repo.get_file_contents(file_path).decoded_content
