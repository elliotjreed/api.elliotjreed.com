from cachetools import cached, TTLCache

cache = TTLCache(maxsize=500, ttl=3600)


@cached(cache)
def post(github_client, category, link):
    repo = github_client.get_repo('elliotjreed/content.elliotjreed.com')
    file_path = repo.get_file_contents(category + '/' + link).path
    return repo.get_file_contents(file_path).decoded_content
