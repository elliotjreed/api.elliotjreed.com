from sanic import Sanic
from sanic.response import json
from sanic.response import raw
from sanic_cors import CORS, cross_origin

from all import all_posts
from categories import categories
from post import post
from posts import posts

app = Sanic("api.elliotjreed.com")
CORS(app)


@app.route("/", methods=["GET", "OPTIONS"])
async def posts_list(request):
    return json(posts())


@app.route("/all", methods=["GET", "OPTIONS"])
async def posts_list(request):
    return json(all_posts())


@app.route("/categories", methods=["GET", "OPTIONS"])
async def categories_list(request):
    return json(categories())


@app.route("/posts/<category:[A-z]+>", methods=["GET", "OPTIONS"])
async def category_posts_list(request, category):
    return json(posts(category))


@app.route("/post/<category:[A-z]+>/<link:string>", methods=["GET", "OPTIONS"])
async def post_html(request, category, link):
    return raw(post(category.title(), link), headers={"Content-Type": "text/markdown; charset=UTF-8"})


if __name__ == "__main__":
    app.run(host="0.0.0.0", port=5000, debug=True, access_log=True)
