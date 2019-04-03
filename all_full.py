from cachetools import cached, TTLCache

cache = TTLCache(maxsize=500, ttl=3600)


@cached(cache)
def all_full(github_client, category=''):
    category = category.title()
    posts_structure = {}
    repo = github_client.get_repo('elliotjreed/content.elliotjreed.com')
    contents = repo.get_file_contents(category)
    while len(contents) > 0:
        file_content = contents.pop(0)
        file_path = file_content.path
        if file_content.type == 'dir':
            contents.extend(repo.get_file_contents(file_path))

        if file_path.endswith('.md'):
            posts_structure[file_path] = repo.get_file_contents(file_path).decoded_content

    return posts_structure
