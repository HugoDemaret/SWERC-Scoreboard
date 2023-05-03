#!/usr/bin/env python3

######################################################################
# Description:                                                       #
# This file contains the scraper. It is responsible for scraping     #
# the scoreboard from codeforces and saving the data to the database.#
######################################################################

# Imports
import os
import json

# Load environment variables
from dotenv import load_dotenv




class User:
    def __init__(self,
                 name: str,
                 profile_url: str,
                 nb_problems_all: str,
                 days_in_a_row: int,
                 nb_problems_month: int,
                 rank: int,

                 ):
        self.name = name
        self.profile_url = profile_url
        self.nb_problems_all = nb_problems_all
        self.days_in_a_row = days_in_a_row
        self.nb_problems_month = nb_problems_month
        self.rank = rank

    def get_name(self):
        return self.name

    def get_profile_url(self):
        return self.profile_url

    def get_nb_problems_all(self):
        return self.nb_problems_all

    def to_json(self):
        return {"name": self.name,
                "profile_url": self.profile_url,
                "nb_problems_all": self.nb_problems_all,
                "days_in_a_row": self.days_in_a_row,
                "nb_problems_month": self.nb_problems_month,
                "rank": self.rank,
                }

    def get_days_in_a_row(self):
        return self.days_in_a_row

    def get_nb_problems_month(self):
        return self.nb_problems_month

    def get_rank(self):
        return self.rank


class Data:
    def __init__(self, path: str, website: str = "codeforces"):
        self.users: set[User] = set()
        self.website = website
        self.path = path
        #self.load_data()


    # Load the data from the json file
    def load_data(self):
        # Load the data from the json file in self.path
        with open(self.path, "r") as f:
            data = json.load(f)
        # Get the users from the data
        users = data["users"]

    # Get the data from codeforces api
    def get_data(self):
        if self.website == "codeforces":
            self.get_codeforces_data()
        else:
            raise NotImplementedError

    def get_codeforces_data(self):
        # Get the data from codeforces api
        # TODO
        pass


    def to_json(self):
        return {"website": self.website,
                "users": [user.to_json() for user in self.users]
                }

    # Save the data to a json file
    def save_data(self):
        #save the data to the json file in self.path
        with open(self.path, "w") as f:
            json.dump(self.to_json(), f, indent=4)


class Scoreboard:
    def __init__(self, data: Data, path: str ="../website/data/scoreboard.json"):
        self.data = data
        self.path = path

    def build_scoreboard(self):
        scoreboard = {}
        for user in self.data.users:
            scoreboard[user.get_name()] = {}
            scoreboard[user.get_name()]["problems_resolved"] = user.get_nb_problems_all()
            scoreboard[user.get_name()]["days_in_a_row"] = user.get_days_in_a_row()
            scoreboard[user.get_name()]["problems_this_month"] = user.get_nb_problems_month()
            scoreboard[user.get_name()]["rank"] = user.get_rank()
        return scoreboard

    def to_json(self):
        return {self.build_scoreboard()}

    def save_scoreboard(self):
        with open(self.path, "w") as f:
            json.dump(self.to_json(), f, indent=4)






def main():
    # Load the environment variables
    # If no .env exists
    if not os.path.exists(".env"):
        # Create a .env file
        with open(".env", "w") as f:
            f.write("DATA_PATH = ../../data.json")
    # Load the environment variables
    load_dotenv()

    path = os.getenv("DATA_PATH")
    # Get the data
    data = Data(path)
    data.get_data()
    data.save_data()
    scoreboard = Scoreboard(data)
    scoreboard.save_scoreboard()





