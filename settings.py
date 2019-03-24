import os
from dotenv import load_dotenv
load_dotenv()

github_access_token = os.getenv('GITHUB_ACCESS_TOKEN')
github_client_id = os.getenv('GITHUB_CLIENT_ID')
github_client_secret = os.getenv('GITHUB_CLIENT_SECRET')
