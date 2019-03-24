from sanic import Sanic
from sanic.response import json
from sanic.response import raw
from sanic_cors import CORS, cross_origin
from github import Github

from settings import github_access_token, github_client_id, github_client_secret

from all import all_posts
from categories import categories
from post import post
from posts import posts

app = Sanic("api.elliotjreed.com")
CORS(app)

github_client = Github(None, None, None, "https://api.github.com", 15, github_client_id, github_client_secret)


@app.route("/", methods=["GET", "OPTIONS"])
async def posts_list(request):
    return json(posts(github_client))


@app.route("/all", methods=["GET", "OPTIONS"])
async def posts_list(request):
    return json(all_posts(github_client))


@app.route("/categories", methods=["GET", "OPTIONS"])
async def categories_list(request):
    return json(categories(github_client))


@app.route("/posts/<category:[A-z]+>", methods=["GET", "OPTIONS"])
async def category_posts_list(request, category):
    return json(posts(github_client, category))


@app.route("/post/<category:[A-z]+>/<link:string>", methods=["GET", "OPTIONS"])
async def post_html(request, category, link):
    return raw(post(github_client, category.title(), link), headers={"Content-Type": "text/markdown; charset=UTF-8"})


if __name__ == "__main__":
    app.run(host="0.0.0.0", port=5000, debug=True, access_log=True)
