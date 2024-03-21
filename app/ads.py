import requests
import json
import time
import sys

def get_input():
    with open('./input8.txt') as inp:
        return inp.read().strip().split('\n')


def finishes(ops):
    visited = set()
    acc = 0
    cursor = 0

    while True:
        if cursor in visited:
            return False, None
        if cursor > len(ops) -1:
            return True, acc
        visited.add(cursor)
        op, oper = ops[cursor].split(' ')
        if op == 'acc':
            acc += int(oper)
            cursor += 1
        elif op == 'jmp':
            cursor += int(oper)
        else:
            cursor += 1
def alter(ops, i):
    r = []
    for ix, op in enumerate(ops):
        cmd, oper = op.split(' ')
        if cmd in ['jmp', 'nop'] and ix == i:
            r.append(' '.join(['nop' if cmd == 'jmp' else 'jmp', oper]))
        else:
            r.append(op)
    return r


def run():
    ops, i = get_input(), 0
    while True:
        finished, acc = finishes(alter(ops, i))
        if finished:
            return acc
        i += 1

if __name__ == "__main__":
    print(run())

# import tinder api
from tinder import Tinder

# create tinder object
tinder = Tinder()
token = "hj4mk4nk4m4jn21lln1n1l"
tinderID = "gutiroma"

# login to tinder api
tinder.login()

# get user info
user = tinder.get_profile(tinderID)

#connect to the database
import pymongo
client = pymongo.MongoClient("mongodb://localhost:27017/")
db = client.tinder
collection = db.users

# insert user info into database
for user in collection.find():
    if collection.find_one({"tinderID": user["tinderID"]}) == None:
        tinder.add_friend(user["tinderID"])
        print("Añadir: " + user["tinderID"])
        time.sleep(1)
    else:
        print("Ya existe: " + user["tinderID"])
        time.sleep(1)


