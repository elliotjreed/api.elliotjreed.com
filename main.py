from sanic import Sanic
from sanic.response import json
from sanic.response import raw
from sanic_cors import CORS
from github import Github
from all import all_posts
from categories import categories
from post import post
from posts import posts

app = Sanic("api.elliotjreed.com")
CORS(app)

github_client = Github()


@app.route("/", methods=["GET", "OPTIONS"])
async def posts_by_category(request):
    return json(posts(github_client))


@app.route("/all", methods=["GET", "OPTIONS"])
async def every_post(request):
    return json(all_posts(github_client))


@app.route("/categories", methods=["GET", "OPTIONS"])
async def categories_list(request):
    return json(categories(github_client))


@app.route("/posts/<category:[A-z]+>", methods=["GET", "OPTIONS"])
async def posts_in_category(request, category):
    return json(posts(github_client, category))


@app.route("/post/<category:[A-z]+>/<link:string>", methods=["GET", "OPTIONS"])
async def post_as_html(request, category, link):
    return raw(post(github_client, category.title(), link), headers={"Content-Type": "text/markdown; charset=UTF-8"})


if __name__ == "__main__":
    app.run(host="0.0.0.0", port=5000, workers=1, debug=False, access_log=False)
