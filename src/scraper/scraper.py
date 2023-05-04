#!/usr/bin/env python3

######################################################################
# Description:                                                       #
# This file contains the scraper. It is responsible for scraping     #
# the scoreboard from codeforces and saving the data to the database.#
######################################################################

# Imports
import os
import json
import requests

# Load environment variables
from dotenv import load_dotenv


class User:
    """
    Class to represent a user
    """

    def __init__(self,
                 name: str,
                 profile_urls: dict,
                 nb_problems_all: int,
                 days_in_a_row: int,
                 nb_problems_month: int,
                 rank: int,

                 ):
        """
        Constructor of the User class
        :param name: the name of the user
        :param profile_urls: the profile urls of the user
        :param nb_problems_all: the number of problems solved (all time)
        :param days_in_a_row: the number of days in a row the user solved a problem
        :param nb_problems_month: the number of problems solved this month
        :param rank: the rank of the user on codeforces (elo)
        """
        self.name = name
        self.profile_urls = profile_urls
        self.nb_problems_all = nb_problems_all
        self.days_in_a_row = days_in_a_row
        self.nb_problems_month = nb_problems_month
        self.rank = rank

    def get_name(self):
        """
        Method to get the name of the user
        :return: the name of the user
        """
        return self.name

    def get_profile_urls(self) -> dict:
        """
        Method to get the profile url of the user
        :return: the profile url of the user
        """
        return self.profile_urls

    def get_nb_problems_all(self) -> int:
        """
        Method to get the number of problems solved by the user
        :return: the number of problems solved by the user
        """
        return self.nb_problems_all

    def to_json(self) -> dict:
        """
        Method to convert the data of the user to json format
        :return: the data of the user in json format
        """
        return {"name": self.name,
                "profile_url": self.profile_urls,
                "nb_problems_all": self.nb_problems_all,
                "days_in_a_row": self.days_in_a_row,
                "nb_problems_month": self.nb_problems_month,
                "rank": self.rank,
                }

    def get_days_in_a_row(self):
        """
        Method to get the number of days in a row the user solved a problem
        :return: the number of days in a row the user solved a problem
        """
        return self.days_in_a_row

    def get_nb_problems_month(self):
        """
        Method to get the number of problems solved this month
        :return: the number of problems solved this month
        """
        return self.nb_problems_month

    def get_rank(self):
        """
        Method to get the rank of the user on codeforces (elo)
        :return: the rank of the user on codeforces (elo)
        """
        return self.rank

    def collect_data(self):
        """
        Method to collect data from the api
        :return: None
        """
        if "codeforces" in self.profile_urls:
            self.collect_data_from_codeforces()
        else:
            print("Error: no profile found for this user")

    def collect_data_from_codeforces(self):
        """
        Method to collect data from codeforces
        :return: None
        """
        url = "https://codeforces.com/api/user.status?handle=" + self.profile_urls["codeforces"]
        response = requests.get(url)
        if response.status_code == 200:
            data = response.json()
            self.nb_problems_all = self.get_nb_problems_all_from_codeforces(data)

        url = "https://codeforces.com/api/user.info?handles=" + self.profile_urls["codeforces"]
        response = requests.get(url)
        if response.status_code == 200:
            data = response.json()
            self.rank = data["result"][0]["rating"]

    def get_nb_problems_all_from_codeforces(self, data: dict) -> int:
        """
        Method to get the number of problems solved by the user from codeforces
        :param data: the data from codeforces
        :return: the number of problems solved by the user from codeforces
        """
        unique_problems = set()
        for submission in data["result"]:
            if submission["verdict"] == "OK":
                unique_problems.add(submission["id"])
        return len(unique_problems)


class Data:
    def __init__(self, path: str, user_list_path: str = "../website/data/users.json"):
        self.users: dict = {}
        self.path = path
        self.user_list_path = user_list_path
        #self.load_data()
        self.load_users()

    def load_users(self):
        with open(self.user_list_path, "r") as f:
            data = json.load(f)
        if data is not None:
            # Get the users from the data
            self.users = data["users"]
        else:
            self.users = {}

    # Load the data from the json file
    def load_data(self):
        # Load the data from the json file in self.path
        with open(self.path, "r") as f:
            data = json.load(f)
        if data is not None:
            # Get the users from the data
            self.users = data["users"]
        else:
            self.users = {}

    # Get the data from apis for every user
    def collect_data(self):
        for user in self.users:
            user.collect_data()

    def get_users(self):
        """
        Method to get the users
        :return: the users
        """
        return self.users

    def to_json_data(self):
        return {
                "users": {user.to_json() for user in self.users}
                }

    # Save the data to a json file
    def save_data(self):
        # save the data to the json file in self.path
        with open(self.path, "w") as f:
            json.dump(self.to_json_data(), f, indent=4)


class Scoreboard:
    def __init__(self, data: Data, path: str = "../website/data/scoreboard.json"):
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
            f.write("DATA_PATH = ./data/data.json\n")
            f.write("USER_LIST_PATH = ../website/data/users.json\n")
            f.write("SCOREBOARD_PATH = ../website/data/scoreboard.json\n")
    # Load the environment variables
    load_dotenv()

    data_path = os.getenv("DATA_PATH")
    # Get the data
    data = Data(data_path, )
    data.collect_data()
    data.save_data()
    scoreboard = Scoreboard(data)
    scoreboard.save_scoreboard()


if __name__ == "__main__":
    main()