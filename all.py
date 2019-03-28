from cachetools import cached, TTLCache

cache = TTLCache(maxsize=500, ttl=3600)


@cached(cache)
def all_posts(github_client):
    posts_structure = []
    repo = github_client.get_repo('elliotjreed/content.elliotjreed.com')
    contents = repo.get_file_contents('')
    while len(contents) > 0:
        file_content = contents.pop(0)
        if file_content.type == 'dir':
            contents.extend(repo.get_file_contents(file_content.path))
        if file_content.path.endswith('.md'):
            file_path = file_content.path
            posts_structure.append(file_path)
    return posts_structure
