from cachetools import cached, TTLCache

cache = TTLCache(maxsize=500, ttl=3600)


@cached(cache)
def categories(github_client):
    categories_list = []
    repo = github_client.get_repo('elliotjreed/content.elliotjreed.com')
    contents = repo.get_file_contents('')
    while len(contents) > 0:
        file_content = contents.pop(0)
        if file_content.type == 'dir':
            categories_list.append(file_content.path)
    return categories_list
